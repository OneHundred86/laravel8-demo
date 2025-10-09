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
# 按实际情况配置
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

### 四、安装依赖

```shell
# 如果原本有该依赖，忽略即可

composer require predis/predis

```


### 五、特殊处理

##### 由于主办方运维没有分配 `role` 操作权限，所以需要修改部分 vendor 源代码。


修改 `SentinelReplication.php` 代码（只有一个代码文件）：


由于`predis`版本差异，该代码文件位置可能在如下路径：
- `vendor/predis/predis/src/Connection/Aggregate/SentinelReplication.php`
- `vendor/predis/predis/src/Connection/Replication/SentinelReplication.php`


```php

    protected function assertConnectionRole(NodeConnectionInterface $connection, $role)
    {
        #region 增加代码
        return;
        #endregion 增加代码

        $role = strtolower($role);
        $actualRole = $connection->executeCommand(RawCommand::create('ROLE'));

        if ($actualRole instanceof Error) {
            throw new ConnectionException($connection, $actualRole->getMessage());
        }

        if ($role !== $actualRole[0]) {
            throw new RoleException($connection, "Expected $role but got $actualRole[0] [$connection]");
        }
    }
```
