<?php

namespace App\Http\Controllers;

use App\Contracts\QuoterContract;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    /**
     * Quoter implementation
     *
     * @var App\Contracts\QuoterContract
     */
    protected $quoter;

    /**
     * Create a new controller instance.
     *
     * @param App\Contract\QuoterContract $quoter
     * @return void
     */
    public function __construct(QuoterContract $quoter)
    {
        $this->quoter = $quoter;
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
        return $this->quoter->getPrices($request->input('t'));
    }
}
