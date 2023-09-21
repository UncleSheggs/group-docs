<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (in_array(php_uname('s'), ['Windows NT'])) {
            Schema::defaultStringLength(191);
        }

        Model::unguard();

        Model::shouldBeStrict( ! $this->app->isProduction());

    }
}
