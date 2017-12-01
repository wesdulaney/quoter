<?php

use App\Services\AlphaVantageFetcher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AlphaVantageFetcherTest extends TestCase
{
    use FetcherContractTests;

    /**
     * Get the service used for testing
     *
     * @return App\Contracts\FetcherContract
     */
    protected function getService()
    {
        return new AlphaVantageFetcher;
    }
}
