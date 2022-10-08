<?php

use App\Http\Controllers\auth\authentikasiController;
use App\Http\Controllers\profile\profileController;
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

Route::group([], function ()
    {
        Route::post('signup',[authentikasiController::class, 'register']);
        Route::post('signin',[authentikasiController::class, 'login']);
    }
);
Route::middleware(['auth:sanctum', 'emailVerified'])->group(function () {
    Route::group(['prefix' => 'profile'], function ()
        {
            Route::post('/',[profileController::class, 'profil']);
            Route::put('edit',[profileController::class, 'edit']);
            Route::put('resetpass',[profileController::class, 'resetPassword']);
        }
    );
});
