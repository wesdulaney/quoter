<?php

namespace App\Providers;

use App\Contracts\FetcherContract;
use App\Services\AlphaVantageFetcher;
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
        // Bind the FetcherContract interface to an implementation
        $this->app->bind(FetcherContract::class, AlphaVantageFetcher::class);
    }
}
