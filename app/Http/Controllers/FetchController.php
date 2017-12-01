<?php

namespace App\Http\Controllers;

use App\Contracts\FetcherContract;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    /**
     * Quoter implementation
     *
     * @var App\Contracts\FetcherContract
     */
    protected $fetcher;

    /**
     * Create a new controller instance.
     *
     * @param App\Contract\FetcherContract $fetcher
     * @return void
     */
    public function __construct(FetcherContract $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * Fetch prices for a set of ticker symbols
     *
     * @param  Request $request
     * @return string
     */
    public function index(Request $request)
    {
        // Get prices
        return $this->fetcher->getPrices($request->input('t'));
    }
}
