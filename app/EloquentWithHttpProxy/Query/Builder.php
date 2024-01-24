<?php

namespace App\EloquentWithHttpProxy\Query;

use App\EloquentWithHttpProxy\Connection;
use Illuminate\Support\Facades\DB;

class Builder
{
    protected Connection $connection;

    /**
     * 目标query builder
     * @var \Illuminate\Database\Query\Builder
     */
    protected $targetQueryBuilder;

    /**
     * @var array{array{method: string, arguments: array}}
     */
    protected array $callArr;

    protected array $fetchResultMethods = [
        "get", "first", "insert", "insertOrIgnore", "insertGetId", "insertUsing", "update", "updateFrom", "updateOrInsert", "upsert", "delete",
        "count", "min", "max", "sum", "avg", "average", "aggregate",
    ];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->targetQueryBuilder = DB::connection($connection->getTargetConnection())->query();
    }

    /**
     * @return Connection
     */
    public function getConnection()
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

        /** 执行目标builder，设置属性 */
        $this->targetQueryBuilder->$method(...$arguments);

        return $this;
    }

    /**
     * 获取目标builder的属性
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->targetQueryBuilder->$name;
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
