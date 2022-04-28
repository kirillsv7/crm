<?php

use App\Http\Controllers\Api\V1\{
    UserController,
    ClientController,
    ProjectController,
    TaskController,
    ResponseController,
};
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
    'prefix' => 'v1',
], function () {
    Route::get('get-auth-check', fn() => Auth::check())->name('getAuthCheck');

    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('get-active-user', fn() => Auth::user())->name('getActiveUser');

        Route::get('user/deleted', [UserController::class, 'deleted'])->name('user.deleted');
        Route::post('user/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('user/list', [UserController::class, 'list'])->name('user.list');

        Route::get('client/deleted', [ClientController::class, 'deleted'])->name('client.deleted');
        Route::post('client/{client}', [ClientController::class, 'restore'])->name('client.restore');
        Route::get('client/list', [ClientController::class, 'list'])->name('client.list');

        Route::get('project/deleted', [ProjectController::class, 'deleted'])->name('project.deleted');
        Route::post('project/{project}', [ProjectController::class, 'restore'])->name('project.restore');
        Route::get('project/statuslist', [ProjectController::class, 'statusList'])->name('project.statuslist');
        Route::get('project/list', [ProjectController::class, 'list'])->name('project.list');
        Route::get('project/recently-added-task', [ProjectController::class, 'recentlyAddedTask'])
             ->name('project.recently-added-task');

        Route::get('task/get-by-project/{project}', [TaskController::class, 'getByProject'])->name('task.get-by-project');
        Route::post('task/add-response', [TaskController::class, 'addResponse'])->name('task.add-response');
        Route::get('task/deleted', [TaskController::class, 'deleted'])->name('task.deleted');
        Route::post('task/{task}', [TaskController::class, 'restore'])->name('task.restore');
        Route::get('task/statuslist', [TaskController::class, 'statusList'])->name('task.statuslist');
        Route::get('task/recently-responsed', [TaskController::class, 'recentlyResponsed'])
             ->name('task.recently-responsed');

        Route::get('response/latest', [ResponseController::class, 'latest'])->name('response.latest');

        Route::apiResources([
            'user'    => UserController::class,
            'client'  => ClientController::class,
            'project' => ProjectController::class,
            'task'    => TaskController::class,
        ]);

        Route::apiResource('response', ResponseController::class)->only('destroy');
    });
});
