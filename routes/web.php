<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group([
    'middleware' => ['auth'],
], function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('user/deleted', [\App\Http\Controllers\UserController::class, 'deleted'])->name('user.deleted');
    Route::post('user/{user}', [\App\Http\Controllers\UserController::class, 'restore'])->name('user.restore');

    Route::get('client/deleted', [\App\Http\Controllers\ClientController::class, 'deleted'])->name('client.deleted');
    Route::post('client/{user}', [\App\Http\Controllers\ClientController::class, 'restore'])->name('client.restore');

    Route::post('project/{project}/add-media', [\App\Http\Controllers\ProjectController::class, 'addMedia'])->name('project.add-media');
    Route::post('project/{project}/remove-media/{id}', [\App\Http\Controllers\ProjectController::class, 'removeMedia'])->name('project.remove-media');
    Route::get('project/deleted', [\App\Http\Controllers\ProjectController::class, 'deleted'])->name('project.deleted');
    Route::post('project/{project}', [\App\Http\Controllers\ProjectController::class, 'restore'])->name('project.restore');

    Route::get('task/deleted', [\App\Http\Controllers\TaskController::class, 'deleted'])->name('task.deleted');
    Route::post('task/{task}', [\App\Http\Controllers\TaskController::class, 'restore'])->name('task.restore');
    Route::post('task/{task}/add-response', [\App\Http\Controllers\TaskController::class, 'addResponse'])->name('task.add-response');

    Route::resources([
        'user'     => \App\Http\Controllers\UserController::class,
        'client'   => \App\Http\Controllers\ClientController::class,
        'project'  => \App\Http\Controllers\ProjectController::class,
        'task'     => \App\Http\Controllers\TaskController::class,
        'response' => \App\Http\Controllers\ResponseController::class,
    ]);
    // TODO add except show to user, client
});
