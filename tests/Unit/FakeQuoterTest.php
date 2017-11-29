<?php

use App\Services\FakeQuoter;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FakeQuoterTest extends TestCase
{
    use QuoterContractTests;

    /**
     * Get the service used for testing
     *
     * @return App\Contracts\Quoter
     */
    protected function getService()
    {
        return new FakeQuoter;
    }
}
