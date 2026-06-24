<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

$start = microtime(true);

$client = new Client([
    'timeout' => 30,  // 全局超时
    'verify' => false, // 关闭ssl验证（测试环境）
]);

$promises = [];

$url = 'http://laravel8.local/debug/wait';
foreach ([1, 2, 3, 1, 3] as $sencods) {
    $promises[] = $client->postAsync($url, [
        'json' => [
            'seconds' => $sencods,
        ],
    ]);
}

// 阻塞等待所有异步请求执行完成（不能控制并行度）
$results = Utils::unwrap($promises);

echo "全部批量异步请求执行完毕\n";

echo "耗时:" . (microtime(true) - $start) . PHP_EOL;

// 获取结果
/**
 * 此时的结果的key是顺序的
 * @var int $index
 * @var \Psr\Http\Message\ResponseInterface $response
 */
foreach ($results as $index => $response) {
    $body = $response->getBody()->getContents();
    echo "[$index] 请求成功，状态码：" . $response->getStatusCode() . PHP_EOL;
    echo "响应内容：" . $body . PHP_EOL . '---' . PHP_EOL;
}
