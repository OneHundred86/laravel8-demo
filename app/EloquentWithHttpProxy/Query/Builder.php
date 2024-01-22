<?php

namespace App\EloquentWithHttpProxy\Query;

use App\EloquentWithHttpProxy\Connection;

class Builder
{
    protected Connection $connection;

    /**
     * @var array{method: string, arguments: array}
     */
    protected array $callArr;

    protected array $fetchResultMethods = [
        "get", "first", "insert", "insertOrIgnore", "insertGetId", "insertUsing", "update", "updateFrom", "updateOrInsert", "upsert", "delete",
        "count", "min", "max", "sum", "avg", "average", "aggregate",
    ];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }


    public function __call($method, $arguments)
    {
        $this->callArr[] = [
            "method" => $method,
            "arguments" => $arguments,
        ];

        if (in_array($method, $this->fetchResultMethods)){
            return $this->fetchResult();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCallArr(): array
    {
        return $this->callArr;
    }



    public function newQuery(): Builder
    {
        return new static($this->connection);
    }


    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchResult()
    {
        return $this->connection->request($this->callArr);
    }
}
