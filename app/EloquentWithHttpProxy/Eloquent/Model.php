<?php

namespace App\EloquentWithHttpProxy\Eloquent;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @inheritdoc
     */
    public function newEloquentBuilder($query)
    {
        if (static::resolveConnection($this->getConnectionName())->getName() == "httpproxy") {
            return new Builder($query);
        }

        return parent::newEloquentBuilder($query);
    }

    /**
     * @inheritdoc
     */
    protected function newBaseQueryBuilder()
    {
        return $this->getConnection()->query();
    }
}
