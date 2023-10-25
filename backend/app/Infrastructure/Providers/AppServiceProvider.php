<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Helpers\Payment\HyperPay;
use App\Infrastructure\Helpers\Payment\MyFatoorah;
use App\Infrastructure\Helpers\Payment\PaymentService;
use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        if (config('services.payment') == 'HyperPay')
        {
            $this->app->bind(PaymentService::class, HyperPay::class);
        }
        elseif (config('services.payment') == 'MyFatoorah')
        {
            $this->app->bind(PaymentService::class, MyFatoorah::class);
        }

        if ($this->app->environment('local'))
        {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

}
