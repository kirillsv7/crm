<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ResponseNonDeletedRelationsScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder
            ->whereRelation('task', 'deleted_at', null)
            ->whereRelation('task.project', 'deleted_at', null)
            ->whereRelation('task.project.client', 'deleted_at', null);
    }
}