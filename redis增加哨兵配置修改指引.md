### 一、`config/database.php`

```php
use Illuminate\Support\Str;

$config = [
    // ...
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            // 'cluster' => env('REDIS_CLUSTER', 'redis'), // 哨兵模式不能有这个配置
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

        // 增加哨兵连接
        'sentinel' => [
            ...explode(',', env('REDIS_SENTINEL_ENDPOINTS')),
            'options' => [
                'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
                'replication' => 'sentinel',
                'service' => env('REDIS_SENTINEL_SERVICE', 'mymaster'),

                'parameters' => [
                    'username' => env('REDIS_USERNAME'),
                    'password' => env('REDIS_PASSWORD', null),
                    'database' => env('REDIS_DB', '0'),
                ],
            ],
        ],
    ],

];

// 强制覆盖 redis.default 配置。因为queue就是使用了 redis.default 配置
$config['redis']['default'] = $config['redis'][env('REDIS_DEFAULT', 'default')];

return $config;

```


### 二、`config/cache.php`

```php
return [
    // ...

    'stores' => [
        // ...

        'redis' => [
            'driver' => 'redis',

            // 按需调整，如果原先没有这些配置，可忽略
            'connection' => env('CACHE_REDIS_DEFAULT_CONNECTION', 'cache'),
            'lock_connection' => env('CACHE_REDIS_LOCK_CONNECTION', 'default'),
        ],
    ],
];

```

### 三、env配置

```dotenv
REDIS_SENTINEL_ENDPOINTS=tcp://127.0.0.1:26379,tcp://127.0.0.1:26380
REDIS_SENTINEL_SERVICE=mymaster
REDIS_CLIENT=predis
REDIS_USERNAME=user1
REDIS_PASSWORD=test123
REDIS_PREFIX="p1:${APP_NAME}:"
REDIS_DEFAULT=sentinel

CACHE_REDIS_DEFAULT_CONNECTION=sentinel
CACHE_REDIS_LOCK_CONNECTION=sentinel

```

