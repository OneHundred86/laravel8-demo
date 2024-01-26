<?php

namespace App\EloquentWithHttpProxy;

use App\EloquentWithHttpProxy\Query\Builder as QueryBuilder;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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

    /**
     * 注意：一个请求只能进行一次dml操作，对于事务里面嵌套多个dml操作的情况不支持。
     *      insert之后再去获取last-insert-id的情况，需要放到同一个request里面。
     * @param string $method
     * @param array $arguments
     * @param string $objType :: Connection | QueryBuilder
     * @param array|null $options
     * @return mixed
     * @throws GuzzleException
     */
    public function request(string $method, array $arguments, string $objType = "Connection", array $options = null)
    {
        $url = $this->config["proxy_url"];
        $response = $this->http->post($url, [
            "json" => [
                "connection" => $this->getTargetConnection(),
                "objType" => $objType,
                "method" => $method,
                "arguments" => base64_encode(json_encode($arguments)),
                "options" => $options,
            ],
        ]);

        $contents = $response->getBody()->getContents();

        return unserialize($contents);
    }

    /**
     * @return QueryBuilder
     */
    public function query()
    {
        return new QueryBuilder($this, $this->getQueryGrammar(), $this->getPostProcessor());
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
