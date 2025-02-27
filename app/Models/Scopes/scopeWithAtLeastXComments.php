<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ScopeWithAtLeastXComments implements Scope
{
    protected int $count;

    public function __construct(int $count = 5) //default value
    {
        $this->count = $count;
    }

    
    public function apply(Builder $builder, Model $model): void
    {
        $builder->has('comments', '>=', $this->count);
    }
}
