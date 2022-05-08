<?php

use Illuminate\Support\Facades\Route;
use App\Http\Resources\V1\User\Resource as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Api\V1\{
    PermissionController,
    UserController,
    ClientController,
    ProjectController,
    TaskController,
    ResponseController,
    MediaController
};

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
    'prefix' => 'v1',
], function () {
    Route::get('get-auth-check', fn() => Auth::check());

    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('get-active-user', fn() => new UserResource(Auth::user()));
        Route::get('get-active-permissions', fn() => Auth::user()->isAdmin
            ? new JsonResource(Permission::pluck('name'))
            : Auth::user()->getAllPermissions()->pluck('name')
        );
        Route::get('permission/{model}/{action}/{id?}', [PermissionController::class, 'check']);

        Route::get('user/deleted', [UserController::class, 'deleted']);
        Route::post('user/{user}', [UserController::class, 'restore']);
        Route::get('user/list', [UserController::class, 'list']);

        Route::get('client/deleted', [ClientController::class, 'deleted']);
        Route::post('client/{client}', [ClientController::class, 'restore']);
        Route::get('client/list', [ClientController::class, 'list']);

        Route::get('project/deleted', [ProjectController::class, 'deleted']);
        Route::post('project/{project}', [ProjectController::class, 'restore']);
        Route::get('project/statuslist', [ProjectController::class, 'statusList']);
        Route::get('project/list', [ProjectController::class, 'list']);
        Route::get('project/recently-added-task', [ProjectController::class, 'recentlyAddedTask']);

        Route::get('task/get-by-project/{project}', [TaskController::class, 'getByProject']);
        Route::post('task/add-response', [TaskController::class, 'addResponse']);
        Route::get('task/deleted', [TaskController::class, 'deleted']);
        Route::post('task/{task}', [TaskController::class, 'restore']);
        Route::get('task/statuslist', [TaskController::class, 'statusList']);
        Route::get('task/recently-responsed', [TaskController::class, 'recentlyResponsed']);

        Route::get('response/get-by-task/{task}', [ResponseController::class, 'getByTask']);
        Route::get('response/latest', [ResponseController::class, 'latest']);

        Route::apiResources([
            'user'    => UserController::class,
            'client'  => ClientController::class,
            'project' => ProjectController::class,
            'task'    => TaskController::class,
        ]);

        Route::delete('response', [ResponseController::class, 'destroy']);
        Route::delete('media/{media}', [MediaController::class, 'destroy']);
    });
});
