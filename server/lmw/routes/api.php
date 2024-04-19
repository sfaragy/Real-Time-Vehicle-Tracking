<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RealTimeController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/realtime-test-event', [RealTimeController::class, 'realtimeTestEvent']);

Route::post('/auth/register', [UserController::class, 'register']);

Route::group(
    [
//        'middleware' => 'api',
        'prefix' => 'auth'
    ],
    function () {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/logout', [UserController::class, 'logout']);
        Route::get('/refresh', [UserController::class, 'refresh']);
    }
);

/* @TODO Need to improve */
Route::group(
    [
//        'middleware' => 'api',
        'prefix' => 'customer'
    ],
    function () {
        Route::get('/{id}', [UserController::class, 'getCustomer']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    }
);

Route::prefix('order')->group(function () {
    Route::post('/', [OrderController::class, 'create']);
    Route::get('/{id}', [OrderController::class, 'getOrder']);
});
