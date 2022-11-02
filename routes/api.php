<?php

use App\Http\Controllers\auth\authentikasiController;
use App\Http\Controllers\profile\profileController;
use App\Http\Controllers\store\storeController;
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

Route::controller(authentikasiController::class)->group(function ()
    {
        Route::post('signup', 'register');
        Route::post('signin', 'login');
    }
);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['emailVerified'])->group(function () {
        Route::group(['prefix' => 'profile'], function ()
            {
                Route::controller(storeController::class)->group(function ()
                {
                        Route::middleware('userAgreement')->group(function () {
                            Route::post('update-store', 'updateStore');
                        });
                        Route::post('create-store', 'registerStore');
                        Route::post('agreement', 'agreementStore');
                    }
                );
                Route::controller(profileController::class)->group(function ()
                    {
                        Route::get('/', 'profil');
                        Route::put('update', 'edit');
                        Route::put('resetpass', 'resetPassword');
                    }
                );
            }
        );
    });
    Route::controller(authentikasiController::class)->group(function ()
        {
            Route::post('verify','verifyEmail');
            Route::post('signout', 'logout');
        }
    );
});
