<?php

namespace App\Services;

use App\Contracts\FetcherContract;
use App\Traits\FetcherContractTools;
use Exception;

class YahooFetcher implements FetcherContract
{
    use FetcherContractTools;

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

        // Check connection
        if (connection_status() != 0) {
            // Internet service is not available
            $this->response['status']   = 404;
            $this->response['errors'][] = [
                'status'  => 404,
                'source'  => '',
                'title'   => 'No Internet Connection',
                'details' => 'Service is unavailable without an internet connection.'
            ];

            return $response;
        }

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
                'details' => 'Missing ticker symbols.'
            ];

            return $response;
        }

        try {
            // Construct Yahoo URL
            $url = 'https://finance.yahoo.com/d/quotes.csv?s=' . implode('+', $tickers) . '&f=sl1';
            
            // Attempt to fetch data
            $csv = @fopen($url, 'r');
            if (empty($csv)) {
                throw new Exception('Request for quotes returned nothing.');
            }

            // Build response
            while ($row = fgetcsv($csv, 4096, ',')) {
                // Update data
                $response['data'][] = [
                    'ticker' => $row[0],
                    'price'  => $row[1]
                ];
            }
            fclose($csv);

            // Return final output
            $response['status'] = 200;
        } catch (Exception $e) {
            $response['status']   = 400;
            $response['data']     = [];
            $response['errors'][] = [
                'status'  => 400,
                'source'  => 'http://finance.yahoo.com/d/quotes.csv',
                'title'   => 'Service Unavailable',
                'details' => $e->getMessage()
            ];
        }

        return $response;
    }
}
