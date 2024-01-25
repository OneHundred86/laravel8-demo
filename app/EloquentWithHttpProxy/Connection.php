<?php

namespace App\EloquentWithHttpProxy;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Database\Connection as BaseConnection;
use Illuminate\Support\Facades\DB;

class Connection extends BaseConnection
{

    protected Client $http;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $targetConnection;

    /**
     * Create a new database connection instance.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->http = new Client();

        $this->targetConnection = DB::connection($this->getTargetConnection());

        $this->queryGrammar = $this->targetConnection->getQueryGrammar();
        $this->postProcessor = $this->targetConnection->getPostProcessor();
    }

    public function getName()
    {
        return "httpproxy";
    }

    /**
     * @return string
     */
    public function getTargetConnection(): string
    {
        return $this->config["target_connection"];
    }

    /**
     * @return Client
     */
    public function getHttp(): Client
    {
        return $this->http;
    }

    /**
     * @param Client $http
     */
    public function setHttp(Client $http): void
    {
        $this->http = $http;
    }

    public function request(string $method, array $arguments)
    {
        $url = $this->config["proxy_url"];
        $response = $this->http->post($url, [
            "json" => [
                "connection" => $this->getTargetConnection(),
                "method" => $method,
                "arguments" => base64_encode(json_encode($arguments)),
            ],
        ]);

        $contents = $response->getBody()->getContents();
        // var_dump("body", $contents);

        return unserialize($contents);
    }

    public function select($query, $bindings = [], $useReadPdo = true)
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function cursor($query, $bindings = [], $useReadPdo = true)
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function insert($query, $bindings = [])
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function update($query, $bindings = [])
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function delete($query, $bindings = [])
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function statement($query, $bindings = [])
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function affectingStatement($query, $bindings = [])
    {
        return $this->request(__FUNCTION__, func_get_args());
    }

    public function transaction(Closure $callback, $attempts = 1)
    {
        throw new \Exception("不支持事务");
    }

    public function beginTransaction()
    {
        throw new \Exception("不支持事务");
    }

    public function commit()
    {
        throw new \Exception("不支持事务");
    }

    public function rollBack($toLevel = null)
    {
        throw new \Exception("不支持事务");
    }
}
