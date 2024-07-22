<?php

# 安装 ext-redis
$redisCluster = new RedisCluster(NULL, [
        "172.25.0.2:6379",
        "172.25.0.3:6379",
        "172.25.0.4:6379",
        "172.25.0.5:6379",
        "172.25.0.6:6379",
        "172.25.0.7:6379",
    ]);

# set / get
$result = $redisCluster->set('k1', 'v1');
var_dump($result);
$result = $redisCluster->get('k1');
var_dump($result);

$result = $redisCluster->set('k2', 'v2');
var_dump($result);
$result = $redisCluster->get('k2');
var_dump($result);

# 在这里，第一个参数只能传master节点的ip和端口
$result = $redisCluster->cluster(["172.25.0.6", 6379], 'nodes');
echo $result;
