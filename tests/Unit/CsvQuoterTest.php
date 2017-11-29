<?php

use App\Services\CsvQuoter;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CsvQuoterTest extends TestCase
{
    use QuoterContractTests;

    /**
     * Get the service used for testing
     *
     * @return App\Contracts\Quoter
     */
    protected function getService()
    {
        return new CsvQuoter;
    }
}
