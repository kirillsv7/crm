<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TaskNonDeletedRelationsScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder
            ->whereRelation('project', 'deleted_at', null)
            ->whereRelation('project.client', 'deleted_at', null);
    }

}