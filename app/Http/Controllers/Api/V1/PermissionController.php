<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function check($model, $action, $id = null)
    {
        $policyName = '\App\Policies\\' . ucfirst($model) . 'Policy';
        if (class_exists($policyName)) {
            $policyInstance = new $policyName();
            if (method_exists($policyInstance, $action)) {
                $modelName     = '\App\Models\\' . ucfirst($model);
                $modelInstance = $id ? $modelName::findOrFail($id) : new $modelName;
                return $policyInstance->$action(Auth::user(), $modelInstance);
            }
        }
    }
}
