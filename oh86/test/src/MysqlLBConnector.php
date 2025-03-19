<?php

namespace Oh86\Test;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Support\Arr;
use PDOException;

class MysqlLBConnector extends MySqlConnector
{
    public function lbConnect(array $config)
    {
        if (!($config['servers'] ?? false)) {
            throw new PDOException('servers is required');
        }

        $servers = explode(',', $config['servers']);
        $serverWeights = $config['servers_weight'] ? explode(',', $config['servers_weight']) : [];

        $serverInfos = [];
        foreach ($servers as $i => $server) {
            $hostAndPort = explode(':', $server);
            $serverInfos[$i] = [
                'host' => $hostAndPort[0],
                'port' => (int) ($hostAndPort[1] ?? 3306),
                'weight' => (int) ($serverWeights[$i] ?? 1),
            ];
        }

        while ($serverInfos) {
            $serverInfo = $this->pullServerInfoByWeight($serverInfos);
            $config['host'] = $serverInfo['host'];
            $config['port'] = $serverInfo['port'];
            try {
                return $this->connect($config);
            } catch (\Exception $e) {
                continue;
            }
        }

        throw $e;
    }

    /**
     * @param array{host:string, port:int, weight:int}[] $name
     */
    protected function pullServerInfoByWeight(array &$serverInfos)
    {
        $totalWeight = array_sum(Arr::pluck($serverInfos, 'weight'));

        mt_srand(time());
        $randomWeight = mt_rand(1, $totalWeight);
        $cur = 0;

        foreach ($serverInfos as $i => $serverInfo) {
            $cur += $serverInfo['weight'];
            if ($randomWeight <= $cur) {
                unset($serverInfos[$i]);
                return $serverInfo;
            }
        }
    }
}