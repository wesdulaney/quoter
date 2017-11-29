<?php

namespace App\Contracts;

/**
 * Interface for fetching prices for ticker symbols
 *
 * method array getPrices($params)
 */
interface QuoterContract
{
    /**
     * Get prices for a set of ticker symbols
     *
     * @param  mixed $params
     * @return string
     */
    public function getPrices($params = null);
}
