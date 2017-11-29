<?php

namespace App\Services;

use App\Contracts\QuoterContract;
use App\Traits\QuoterContractTools;

class FakeQuoter implements QuoterContract
{
    use QuoterContractTools;

    /**
     * Get prices for a set of ticker symbols
     *
     * @param  mixed $params
     * @return string
     */
    public function getPrices($params = null)
    {
        // Init response
        $response = ['status' => 400, 'data' => [], 'errors' => []];

        // Prepare tickers
        $num_args = func_num_args();
        if ($num_args > 1) {
            $arg_list = func_get_args();
            $params   = [];
            for ($i = 0; $i < $num_args; $i++) {
                $params[] = $arg_list[$i];
                $tickers  = call_user_func_array([$this, 'prepTickers'], $params);
            }
        } else {
            $tickers = call_user_func_array([$this, 'prepTickers'], [$params]);
        }

        // Check input
        if (empty($tickers)) {
            $response['errors'][] = [
                'status'  => 400,
                'source'  => '',
                'title'   => 'Invalid Request',
                'details' => 'Missing ticker symbols'
            ];

            return $response;
        }

        // Prepare list of tickers with fake prices
        foreach ($tickers as $ticker) {
            $response['data'][] = [
                'ticker' => $ticker,
                'price'  => '25.00'
            ];
        }

        // Return final output
        $response['status'] = 200;

        return $response;
    }
}
