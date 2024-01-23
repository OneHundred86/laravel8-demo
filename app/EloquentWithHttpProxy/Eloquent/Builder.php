<?php

namespace App\EloquentWithHttpProxy\Eloquent;

use Illuminate\Database\Eloquent\Scope;
use Closure;

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


    /**
     * Apply the scopes to the Eloquent builder instance and return it.
     *
     * @return static
     */
    public function applyScopes()
    {
        if (! $this->scopes) {
            return $this;
        }

        $builder = clone $this;

        foreach ($this->scopes as $identifier => $scope) {
            if (! isset($builder->scopes[$identifier])) {
                continue;
            }

                // If the scope is a Closure we will just go ahead and call the scope with the
                // builder instance. The "callScope" method will properly group the clauses
                // that are added to this query so "where" clauses maintain proper logic.
                if ($scope instanceof Closure) {
                    $scope($builder);
                }

                // If the scope is a scope object, we will call the apply method on this scope
                // passing in the builder and the model instance. After we run all of these
                // scopes we will return back the builder instance to the outside caller.
                if ($scope instanceof Scope) {
                    $scope->apply($builder, $this->getModel());
                }
            }

        return $builder;
    }
}
