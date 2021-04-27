<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients;
use App\Http\Controllers\Actions;
use App\Http\Controllers\AuthController;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

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


// Public Routes
Route::post('/register', [AuthController::class, 'register'] );
Route::post('/login', [AuthController::class, 'login'] );


// Unauthorized
Route::get('login', function(){
    return "You need to auth!";
})->name('login');

// Protected Routes
Route::group( ['middleware' => ['auth:sanctum']], function(){

    // Clients

    Route::get('/clients/all', [Clients::class, 'index'] );
    Route::get('/clients/{id}', [Clients::class, 'show']);
    Route::get('/clients/search/{name}', [Clients::class, 'search']);
    Route::post('/clients', [Clients::class, 'store'] );
    Route::put('/clients/{id}', [Clients::class, 'update'] );
    Route::delete('/clients/{id}', [Clients::class, 'destroy'] );
    Route::post('/logout', [AuthController::class, 'logout'] );


    // Actions

    Route::get('/clients/getReport/{ano}/{month}/{client}', [Actions::class, 'getReport'] );
    Route::get('/clients/getAction/{id}', [Actions::class, 'index'] );
    Route::post('/clients/addAction/', [Actions::class, 'store'] );
    Route::delete('/clients/delAction/{id}', [Actions::class, 'destroy']);
    Route::put('/clients/updateAction/{id}', [Actions::class, 'update']);

});

Route::get('/', function(){
    return ["error" => "Unknown route!"];
});
