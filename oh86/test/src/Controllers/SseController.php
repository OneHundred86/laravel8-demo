<?php

namespace Oh86\Test\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SseController
{
    /**
     * SSE 流端点 - 基础版本
     */
    public function stream(Request $request)
    {
        // 设置 SSE 响应头
        $response = new StreamedResponse(function () use ($request) {
            // 禁用输出缓冲
            if (ob_get_level()) {
                ob_end_clean();
            }

            // 设置无限执行时间
            set_time_limit(0);


            // 发送 SSE 头部
            echo "event: connected\n";  // 对应浏览器 eventSource的`connected`事件：eventSource.addEventListener('connected', (e) => {log(`连接事件: ${e.data}`, 'event-connected');});
            echo "data: " . json_encode(['message' => 'SSE 连接已建立', 'time' => now()->toDateTimeString()]) . "\n\n"; // 对应上面的e.data
            flush();

            // 发送注释（浏览器会忽略这个消息）
            echo ":ping\n\n";
            flush();

            $counter = 0;
            $maxMessages = 10; // 发送10条消息后关闭（演示用）

            while ($counter < $maxMessages) {
                // 检查客户端是否断开连接
                if (connection_aborted()) {
                    Log::info('SSE 连接被客户端中断');
                    break;
                }

                $counter++;

                // 构造数据
                $data = [
                    'id' => $counter,
                    'message' => "服务器推送消息 #{$counter}",
                    'timestamp' => now()->toDateTimeString(),
                    'microtime' => microtime(true),
                    'memory' => round(memory_get_usage() / 1024 / 1024, 2) . 'MB'
                ];

                /*
                SSE 数据格式：
                字段名: 值\n
                字段名: 值\n
                \n          ← 空行表示一条消息结束


                核心规则：
                - 每行以 \n（LF，换行符）结尾；eg：`data: `
                - 空行（连续两个 \n）触发消息派发
                - 字段名大小写敏感
                - 值前空格会被自动去除


                常用字段：
                | 字段      | 必需 | 说明                 | 示例              |
                | ------- | -- | ------------------ | --------------- |
                | `data`  | 否  | 消息数据（可多行）          | `data: hello`   |
                | `event` | 否  | 事件类型（默认 `message`） | `event: update` |
                | `id`    | 否  | 消息 ID（用于断线重连）      | `id: 12345`     |
                | `retry` | 否  | 重连间隔（毫秒）           | `retry: 5000`   |
                | `:注释`   | 否  | 注释/心跳（冒号开头），保持连接 | `: ping`    |

                */
                // 发送 SSE 格式数据
                echo "id: {$counter}\n";
                echo "event: message\n";  // 对应浏览器 eventSource的`message`事件：eventSource.addEventListener('message', (e) => {const data = JSON.parse(e.data);log(`消息 #${data.id}: ${data.message} (内存: ${data.memory})`, 'event-message');});
                echo "data: " . json_encode($data) . "\n\n"; // 对应上面的e.data

                // 立即刷新到客户端
                flush();

                Log::debug("SSE 发送消息 #{$counter}");

                // 每秒发送一条
                sleep(1);
            }

            // 发送结束事件
            echo "event: close\n";
            echo "data: " . json_encode(['message' => '流已结束']) . "\n\n";
            flush();

            Log::info('SSE 流正常结束');
        });

        // 设置响应头
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no'); // 禁用 Nginx 缓冲

        return $response;
    }

    /**
     * SSE 流端点 - 带心跳版本（生产环境推荐）
     */
    public function streamWithHeartbeat(Request $request)
    {
        $response = new StreamedResponse(function () use ($request) {
            if (ob_get_level()) {
                ob_end_clean();
            }

            set_time_limit(0);

            // 发送初始连接事件
            echo "event: connected\n";
            echo "data: " . json_encode([
                'client_ip' => $request->ip(),
                'connection_time' => now()->toDateTimeString()
            ]) . "\n\n";
            flush();

            $lastActivity = time();
            $heartbeatInterval = 15; // 15秒心跳
            $maxIdleTime = 60;       // 60秒无活动断开

            while (true) {
                if (connection_aborted()) {
                    Log::info('SSE 心跳连接中断');
                    break;
                }

                $currentTime = time();

                // 发送心跳保持连接（防止代理超时）
                if ($currentTime - $lastActivity >= $heartbeatInterval) {
                    echo "event: heartbeat\n";
                    echo "data: " . json_encode(['time' => now()->toDateTimeString()]) . "\n\n";
                    flush();
                    $lastActivity = $currentTime;
                    Log::debug('SSE 心跳发送');
                }

                // 检查是否有新数据（这里模拟数据库轮询或 Redis 订阅）
                // 实际项目中可以查询数据库或监听 Redis 频道
                if ($this->hasNewData()) {
                    $data = $this->fetchNewData();
                    echo "id: " . uniqid() . "\n";
                    echo "event: notification\n";
                    echo "data: " . json_encode($data) . "\n\n";
                    flush();
                    $lastActivity = $currentTime;
                }

                // 空闲超时检查
                if ($currentTime - $lastActivity > $maxIdleTime) {
                    echo "event: timeout\n";
                    echo "data: " . json_encode(['message' => '连接空闲超时']) . "\n\n";
                    flush();
                    break;
                }

                usleep(500000); // 0.5秒轮询间隔
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    /**
     * 模拟检查新数据
     */
    private function hasNewData(): bool
    {
        // 实际项目中查询数据库或 Redis
        // 这里随机模拟有 10% 概率有新数据
        return rand(1, 100) <= 10;
    }

    /**
     * 模拟获取新数据
     */
    private function fetchNewData(): array
    {
        return [
            'type' => 'notification',
            'title' => '新消息 ' . rand(1000, 9999),
            'content' => '这是随机生成的消息内容',
            'created_at' => now()->toDateTimeString()
        ];
    }
}
