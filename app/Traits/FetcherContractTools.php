<?php

namespace App\Traits;

trait FetcherContractTools
{
    /**
     * Prepare an array of tickers from parameters
     *
     * @param  mixed $params
     * @return array
     */
    public function prepTickers($params)
    {
        // Init list of tickers
        $tickers = [];

        // Allow multiple params
        $num_args = func_num_args();
        if ($num_args > 1) {
            $arg_list = func_get_args();
            for ($i = 0; $i < $num_args; $i++) {
                $tickers[] = $arg_list[$i];
            }
        } else {
            if (is_array($params)) {
                $tickers = array_merge($tickers, $params);
            } else {
                // This is a single string
                if (!empty($params)) {
                    if (strpos($params, ',') !== false) {
                        // Split on commas
                        $params = explode(',', trim($params));
                    } else {
                        // Split on spaces
                        $params = explode(' ', trim($params));
                    }

                    // Add tickers
                    foreach ($params as $param) {
                        if (!empty($param)) {
                            $tickers[] = $param;
                        }
                    }
                }
            }
        }

        // Cleanup tickers
        $tickers = array_map('trim', $tickers);

        return $tickers;
    }
}
