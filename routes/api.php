<?php

use App\Http\Controllers\Api\SampleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [SampleController::class, 'test']);
Route::controller(SampleController::class)
    ->group(function () {
        Route::get('event/{userId}', 'sampleEventListener');
        Route::get('dql/todo/{todoId}', 'sampleDqlWithDto');
        Route::get('repository', 'sampleRepository');
        Route::post('schedule', 'createSchedules');
        Route::post('user', 'createUser');
        Route::post('user/{userId}/todo', 'createUserTodo');
    });