<?php

namespace App\EloquentWithHttpProxy;

use App\EloquentWithHttpProxy\Query\Builder as QueryBuilder;
use GuzzleHttp\Client;
use Illuminate\Database\Connection as BaseConnection;

class Connection extends BaseConnection
{

    protected Client $http;

    /**
     * Create a new database connection instance.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->http = new Client();
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
     * Get a new query builder instance.
     *
     * @return QueryBuilder
     */
    public function query()
    {
        return new QueryBuilder($this);
    }

    /**
     * @param array $callArr
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(array $callArr)
    {
        $url = $this->config["proxy_url"];
        $response = $this->http->post($url, [
            "json" => [
                "connection" => $this->getTargetConnection(),
                "callArr" => $callArr,
            ],
        ]);

        $contents = $response->getBody()->getContents();
        // var_dump("body", $contents);

        return unserialize($contents);
    }
}
