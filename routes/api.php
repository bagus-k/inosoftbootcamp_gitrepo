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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('login'. 'App\Http\Controllers\AuthController@login');

Route::group([
    'prefix' => 'auth'
], function() {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register','App\Http\Controllers\AuthController@register');
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout','App\Http\Controllers\AuthController@logout');
        Route::post('refresh','App\Http\Controllers\AuthController@refresh');
        
        Route::prefix('task')->group(function() {
            Route::get('/show_tasks', 'App\Http\Controllers\TaskController@showTasks');
            Route::post('/create_task', 'App\Http\Controllers\TaskController@createTask');
            Route::put('/update_task', 'App\Http\Controllers\TaskController@updateTask');
            Route::delete('/delete_task/{taskId}', 'App\Http\Controllers\TaskController@deleteTask');
            Route::get('/search_task/{title}', 'App\Http\Controllers\TaskController@searchTask');
        });
    });
});
