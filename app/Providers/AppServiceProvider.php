<?php

namespace App\Providers;

use App\Repository\Otp\IOtpRepository;
use App\Repository\User\IUserRepository;
use App\Repository\Otp\OtpRepository;
use App\Repository\User\UserRepository;
use App\Services\Otp\IOtpService;
use App\Services\Otp\OtpService;
use App\Services\sendMail\ISendMail;
use App\Services\sendMail\SendMail;
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

        // Otp
        $this->app->bind(IOtpRepository::class, OtpRepository::class);
        $this->app->bind(IOtpService::class, OtpService::class);

        // Notification
        $this->app->bind(ISendMail::class, SendMail::class);
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
