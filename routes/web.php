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

    Route::get('project/deleted', [\App\Http\Controllers\ProjectController::class, 'deleted'])->name('project.deleted');
    Route::post('project/{project}', [\App\Http\Controllers\ProjectController::class, 'restore'])->name('project.restore');

    Route::resources([
        'user'    => \App\Http\Controllers\UserController::class,
        'client'  => \App\Http\Controllers\ClientController::class,
        'project' => \App\Http\Controllers\ProjectController::class,
    ]);
});
