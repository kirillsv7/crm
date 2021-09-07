<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix'     => 'v1',
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResources([
        'user'    => \App\Http\Controllers\Api\V1\UserController::class,
        'client'  => \App\Http\Controllers\Api\V1\ClientController::class,
        'project' => \App\Http\Controllers\Api\V1\ProjectController::class,
        'task'    => \App\Http\Controllers\Api\V1\TaskController::class,
    ]);
});
