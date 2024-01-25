<?php

namespace App\EloquentWithHttpProxy\Query;

use App\EloquentWithHttpProxy\Connection;
use Illuminate\Database\Query\Builder as BaseQueryBuilder;

class Builder extends BaseQueryBuilder
{
    /**
     * @var Connection
     */
    public $connection;

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param  array  $values
     * @param  string|null  $sequence
     * @return int
     */
    public function insertGetId(array $values, $sequence = null)
    {
        return $this->connection->request(__FUNCTION__, func_get_args(), "QueryBuilder", [
            "from" => $this->from,
        ]);
    }
}
