<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;

$start = microtime(true);

$client = new Client([
    'timeout' => 30,  // 全局超时
    'verify' => false, // 关闭ssl验证（测试环境）
]);

// 1. 构造请求迭代器（生成所有待异步请求）
$requests = function () {
    $url = 'http://laravel8.local/debug/wait';
    foreach ([1, 2, 3, 1, 3] as $seconds) {
        yield new Request(
            'POST',
            $url,
            [
                'User-Agent' => 'Guzzle Async Pool',
                'Content-Type' => 'application/json',
            ],
            json_encode([
                'seconds' => $seconds,
            ])
        );
    }
};

$results = [];

// 2. 创建连接池，设置最大并发数
$pool = new Pool($client, $requests(), [
    'concurrency' => 5, // 同时最多5个请求并发，按需调整
    // 请求成功回调
    'fulfilled' => function ($response, $index) use (&$results) {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        /** @var int $index */

        $results[$index] = $response;

        // $body = $response->getBody()->getContents();
        // echo "[$index] 请求成功，状态码：" . $response->getStatusCode() . PHP_EOL;
        // echo "响应内容：" . $body . PHP_EOL . '---' . PHP_EOL;
    },
    // 请求失败回调（超时、4xx、5xx、网络错误都会进入）
    'rejected' => function (GuzzleException $e, $index) {
        // echo "[$index] 请求失败：" . $e->getMessage() . PHP_EOL . '---' . PHP_EOL;
        throw new Exception($e->getMessage());
    },
]);

// 3. 阻塞等待所有异步请求执行完成
$pool->promise()->wait();
echo "全部批量异步请求执行完毕\n";

echo "耗时:" . (microtime(true) - $start) . PHP_EOL;

// 4. 获取结果
// 注意：$results 的key是乱序的
// ksort($results);
foreach ($results as $index => $response) {
    $body = $response->getBody()->getContents();
    echo "[$index] 请求成功，状态码：" . $response->getStatusCode() . PHP_EOL;
    echo "响应内容：" . $body . PHP_EOL . '---' . PHP_EOL;
}
