<?php

use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function(){
    /**
     * Auth
     */
    Route::group(['prefix' => 'auth'], function(){
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::post('register', [UserController::class, 'register']);
    
        Route::middleware('auth:sanctum')->group( function () {
            Route::get('profile', [UserController::class, 'profile']);
            Route::get('logout', [UserController::class, 'logout']);
        });
    });

    Route::middleware('auth:sanctum')->group( function () {
        Route::resource('vehicles', VehicleController::class)->only('index', 'update', 'destroy', 'show', 'store');
        Route::post('sales', [SalesController::class, 'store']);
        Route::get('sales/report', [SalesController::class, 'report']);
    });
});