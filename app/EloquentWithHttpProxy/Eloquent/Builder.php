<?php

namespace App\EloquentWithHttpProxy\Eloquent;

class Builder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * @var \App\EloquentWithHttpProxy\Query\Builder
     */
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
