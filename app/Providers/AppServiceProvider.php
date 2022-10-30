<?php

namespace App\Providers;

use App\Repository\Otp\IOtpRepository;
use App\Repository\User\IUserRepository;
use App\Repository\Otp\OtpRepository;
use App\Repository\Store\IStoreRepository;
use App\Repository\Store\StoreRepository;
use App\Repository\User\UserRepository;
use App\Repository\userAgreement\IUserAgreementRepository;
use App\Repository\userAgreement\UserAgreementRepository;
use App\Services\Otp\IOtpService;
use App\Services\Otp\OtpService;
use App\Services\sendMail\ISendMail;
use App\Services\sendMail\SendMail;
use App\Services\Store\IStoreService;
use App\Services\Store\StoreService;
use App\Services\User\IUserService;
use App\Services\User\UserService;
use App\Services\userAgreement\IUserAgreementService;
use App\Services\userAgreement\UserAgreementService;
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

        // Store
        $this->app->bind(IStoreRepository::class, StoreRepository::class);
        $this->app->bind(IStoreService::class, StoreService::class);

        // User Agreement
        $this->app->bind(IUserAgreementRepository::class, UserAgreementRepository::class);
        $this->app->bind(IUserAgreementService::class, UserAgreementService::class);
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
