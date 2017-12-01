<?php

use App\Services\FakeFetcher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FakeFetcherTest extends TestCase
{
    use FetcherContractTests;

    /**
     * Get the service used for testing
     *
     * @return App\Contracts\FetcherContract
     */
    protected function getService()
    {
        return new FakeFetcher;
    }
}
