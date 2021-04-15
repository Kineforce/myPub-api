<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients;
use App\Models\Client;

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
Route::get('/clients', [Clients::class, 'index'] );
Route::get('/clients/{id}', [Clients::class, 'show']);
Route::get('/clients/search/{name}', [Clients::class, 'search']);
Route::get('login', function(){
    return "You need to auth!";
})->name('login');

// Protected Routes
Route::group( ['middleware' => ['auth:sanctum']], function(){
    Route::post('/clients', [Clients::class, 'store'] );
    Route::put('/clients/{id}', [Clients::class, 'update'] );
    Route::delete('/clients/{id}', [Clients::class, 'destroy'] );

});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
