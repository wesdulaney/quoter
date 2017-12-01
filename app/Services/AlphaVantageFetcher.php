<?php

namespace App\Services;

use App\Contracts\FetcherContract;
use App\Traits\FetcherContractTools;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

class AlphaVantageFetcher implements FetcherContract
{
    use FetcherContractTools;

    /**
     * Alpha Vantage API endpoint
     *
     * @var string
     */
    protected $api_url;

    /**
     * Alpha Vantage API key
     *
     * @var string
     */
    protected $api_key;

    /**
     * Guzzle client
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Assign members
        $this->api_url = env('ALPHA_VANTAGE_API_URL');
        $this->api_key = env('ALPHA_VANTAGE_API_KEY');
        $this->client  = new GuzzleClient();
    }

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
            foreach ($tickers as $ticker) {
                // Update data
                $response['data'][] = $this->query($ticker);
            }

            // Return final output
            $response['status'] = 200;
        } catch (Exception $e) {
            $response['status']   = 400;
            $response['data']     = [];
            $response['errors'][] = [
                'status'  => 400,
                'source'  => 'https://www.alphavantage.co',
                'title'   => 'Service Unavailable',
                'details' => $e->getMessage()
            ];
        }

        return $response;
    }

    /**
     * Request price info from remote service
     * 
     * @param  string $ticker
     * @return array
     */
    protected function query($ticker)
    {
        // Set params for remote fetch
        $params = [
            'function' => 'TIME_SERIES_INTRADAY',
            'interval' => '1min',
            'symbol'   => $ticker,
            'apikey'   => $this->api_key
        ];

        // Request
        $response = $this->client->get($this->api_url . http_build_query($params));
        
        // Parse result
        $result = json_decode($response->getBody()->getContents(), true);
        $index  = $result['Meta Data']['3. Last Refreshed'];
        $last   = $result['Time Series (1min)'][$index];

        // Output
        return ['ticker' => $ticker, 'price'  => round(floatval($last['4. close']), 2)];
    }
}
