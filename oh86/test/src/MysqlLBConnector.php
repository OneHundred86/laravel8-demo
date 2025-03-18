<?php

namespace Oh86\Test;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Support\Arr;
use PDOException;

class MysqlLBConnector extends MySqlConnector
{
    public function tryConnect(array $config)
    {
        if (!($config['hosts'] ?? false)) {
            throw new PDOException('hosts is required');
        }

        $hosts = explode(',', $config['hosts']);
        $hosts = Arr::shuffle($hosts, time());
        foreach ($hosts as $host) {
            $config['host'] = $host;
            try {
                return $this->connect($config);
            } catch (\Exception $e) {
                continue;
            }
        }

        throw $e;
    }
}