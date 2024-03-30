<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

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

/*
 * Peedge : TpkSTa3G8X9bPyh : 6|KmummZ6j7zoykrIAQmBpf35dlL9guUTb3jxsc6b6
 */

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user/me', 'App\Http\Controllers\UserController@me');
    Route::post('/user/logout', 'App\Http\Controllers\UserAuthController@logout');

    Route::middleware('managing')->group(function () {
        Route::post('/users', 'App\Http\Controllers\UserController@store');
        Route::put('/users/{id}', 'App\Http\Controllers\UserController@update');
        Route::delete('/users/{id}', 'App\Http\Controllers\UserController@delete');
        Route::get('/users/{id}/generate/token', 'App\Http\Controllers\UserAuthController@createAuthenticationToken');
    });

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe']);

    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/users/all', 'App\Http\Controllers\UserController@all');
    Route::get('/users/licensed', 'App\Http\Controllers\UserController@licensed');
    Route::get('/users/managing', 'App\Http\Controllers\UserController@managing');

    Route::get('/users/search', 'App\Http\Controllers\UserController@search');
    Route::get('/users/{id}', 'App\Http\Controllers\UserController@show');

    Route::middleware('managing')->group(function () {
        Route::post('/convocations', 'App\Http\Controllers\ConvocationController@store');
        Route::put('/convocations/{id}', 'App\Http\Controllers\ConvocationController@update');
        Route::delete('/convocations/{id}', 'App\Http\Controllers\ConvocationController@delete');
    });

    Route::get('/convocations', 'App\Http\Controllers\ConvocationController@index');
    Route::get('/me/convocations', 'App\Http\Controllers\ConvocationController@myConvocations');
    Route::get('/convocations/{id}', 'App\Http\Controllers\ConvocationController@show');
    Route::post('/convocations/{id}/accept', 'App\Http\Controllers\ConvocationController@accept');
    Route::post('/convocations/{id}/decline', 'App\Http\Controllers\ConvocationController@decline');
    Route::get('/convocations/search', 'App\Http\Controllers\ConvocationController@search');
});

Route::get('/user/login', function (Request $request) {
    return response()->json(['message' => 'Invalid credentials'], 401);
})->name('login');
Route::post('/user/login', 'App\Http\Controllers\UserAuthController@login');
