<?php

namespace App\Providers;

use App\Repository\Otp\IOtpRepository;
use App\Repository\User\IUserRepository;
use App\Repository\Otp\OtpRepository;
use App\Repository\User\UserRepository;
use App\Services\Otp\IOtpService;
use App\Services\Otp\OtpService;
use App\Services\User\IUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // User
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserService::class, UserService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
