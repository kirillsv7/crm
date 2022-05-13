<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function check($model, $action, $id = null)
    {
        $model      = ucfirst($model);
        $policy = '\App\Policies\\' . $model . 'Policy';

        if (!class_exists($policy)) {
            return false;
        }

        $policyInstance = new $policy();

        if (!method_exists($policyInstance, $action)) {
            return false;
        }

        $model = '\App\Models\\' . $model;

        $modelInstance = $id ? $model::findOrFail($id) : new $model;

        return $policyInstance->$action(Auth::user(), $modelInstance);
    }
}
