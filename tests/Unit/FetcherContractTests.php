<?php

trait FetcherContractTests
{
    /**
     * Get the service used for these tests
     *
     * @return App\Contracts\FetcherContract
     */
    abstract protected function getService();

    /**
     * @test
     */
    public function a_string_with_one_ticker_is_valid()
    {
        // Get the service
        $service = $this->getService();

        // Arrange a string with a ticker
        $tickers = 'VCLT';

        // Act to get prices
        $response = $service->getPrices($tickers);

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Get data as a collection to assist with further assertions
        $data = collect($response['data']);

        // Assert that the ticker is in the result set
        $this->assertTrue($data->contains('ticker', 'VCLT'));

        // Assert that price is set
        $filtered = $data->where('ticker', 'VCLT')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);
    }

    /**
     * @test
     */
    public function a_string_with_comma_separated_tickers_is_valid()
    {
        // Get the service
        $service = $this->getService();

        // Arrange a string with tickers separated by commas
        $tickers = 'VCLT, IAU, SLV, ^SPX';

        // Act to get prices
        $response = $service->getPrices($tickers);

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Get data as a collection to assist with further assertions
        $data = collect($response['data']);

        // Assert that the tickers are in the result set
        $this->assertTrue($data->contains('ticker', 'VCLT'));
        $this->assertTrue($data->contains('ticker', 'IAU'));
        $this->assertTrue($data->contains('ticker', 'SLV'));
        $this->assertTrue($data->contains('ticker', '^SPX'));

        // Assert that prices are set
        $filtered = $data->where('ticker', 'VCLT')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'IAU')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'SLV')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', '^SPX')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);
    }

    /**
     * @test
     */
    public function a_string_with_space_separated_tickers_is_valid()
    {
        // Get the service
        $service = $this->getService();

        // Arrange a string with tickers separated by commas
        $tickers = 'VCLT IAU SLV ^SPX';

        // Act to get prices
        $response = $service->getPrices($tickers);

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Get data as a collection to assist with further assertions
        $data = collect($response['data']);

        // Assert that the tickers are in the result set
        $this->assertTrue($data->contains('ticker', 'VCLT'));
        $this->assertTrue($data->contains('ticker', 'IAU'));
        $this->assertTrue($data->contains('ticker', 'SLV'));
        $this->assertTrue($data->contains('ticker', '^SPX'));

        // Assert that prices are set
        $filtered = $data->where('ticker', 'VCLT')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'IAU')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'SLV')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', '^SPX')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);
    }

    /**
     * @test
     */
    public function an_array_of_tickers_is_valid()
    {
        // Get the service
        $service = $this->getService();

        // Arrange an array of tickers
        $tickers = ['VCLT', 'IAU', 'SLV', '^SPX'];

        // Act to get prices
        $response = $service->getPrices($tickers);

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Get data as a collection to assist with further assertions
        $data = collect($response['data']);

        // Assert that the tickers are in the result set
        $this->assertTrue($data->contains('ticker', 'VCLT'));
        $this->assertTrue($data->contains('ticker', 'IAU'));
        $this->assertTrue($data->contains('ticker', 'SLV'));
        $this->assertTrue($data->contains('ticker', '^SPX'));

        // Assert that prices are set
        $filtered = $data->where('ticker', 'VCLT')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'IAU')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'SLV')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', '^SPX')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);
    }

    /**
     * @test
     */
    public function a_set_of_tickers_is_valid()
    {
        // Get the service
        $service = $this->getService();

        // Act to get prices on a set of tickers
        $response = $service->getPrices('VCLT', 'IAU', 'SLV', '^SPX');

        // Assert response status
        $this->assertEquals(200, $response['status']);

        // Get data as a collection to assist with further assertions
        $data = collect($response['data']);

        // Assert that the tickers are in the result set
        $this->assertTrue($data->contains('ticker', 'VCLT'));
        $this->assertTrue($data->contains('ticker', 'IAU'));
        $this->assertTrue($data->contains('ticker', 'SLV'));
        $this->assertTrue($data->contains('ticker', '^SPX'));

        // Assert that prices are set
        $filtered = $data->where('ticker', 'VCLT')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'IAU')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', 'SLV')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);

        $filtered = $data->where('ticker', '^SPX')->first();
        $this->assertNotNull($filtered['price']);
        $this->assertGreaterThan(0, $filtered['price']);
    }

    /**
     * @test
     */
    public function no_tickers_is_invalid()
    {
        // Get the service
        $service = $this->getService();

        // Act to get prices on an empty set of tickers
        $response = $service->getPrices();

        // Assert response status
        $this->assertEquals(400, $response['status']);
    }
}
