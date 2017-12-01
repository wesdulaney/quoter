<?php

use App\Services\YahooFetcher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class YahooFetcherTest extends TestCase
{
    use FetcherContractTests;

    /**
     * Scaffolding
     */
    public function setUp()
    {
        $this->markTestSkipped('The Yahoo Finance Service is not available.');
    }

    /**
     * Get the service used for testing
     *
     * @return App\Contracts\FetcherContract
     */
    protected function getService()
    {
        return new YahooFetcher;
    }
}
