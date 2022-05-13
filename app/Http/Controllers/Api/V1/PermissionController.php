<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function check($model, $action, $id = null): bool
    {
        $model  = ucfirst($model);
        $policy = '\App\Policies\\' . $model . 'Policy';
        $model  = '\App\Models\\' . $model;

        if (
            !class_exists($model) ||
            !class_exists($policy) ||
            !method_exists($policy, $action)
        ) {
            return false;
        }

        $modelInstance  = $id ? $model::findOrFail($id) : new $model;
        $policyInstance = new $policy;

        return $policyInstance->$action(Auth::user(), $modelInstance);
    }
}
