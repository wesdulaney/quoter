<?php

namespace App\Providers;

use App\Contracts\QuoterContract;
use App\Services\CsvQuoter;
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
        // Bind the QuoterContract interface to an implementation
        $this->app->bind('App\Services\CsvQuoter', function () {
            return new CsvQuoter();
        });

        $this->app->bind('App\Contracts\QuoterContract', 'App\Services\CsvQuoter');
    }
}
