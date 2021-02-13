<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Endpoint checkout.
     *
     * @var string
     */
    protected $endpointCheckout = '/api/checkout';

    /**
     * Endpoint checkout.
     *
     * @var string
     */
    protected $endpointPayment = '/api/payment';

    /**
     * Setup the test environment.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Test Create endpoint is success.
     *
     * @return void
     */
    public function testCheckoutEndpointWorkAsExpected()
    {
        $product = Product::find(1);

        $data = [
            'product_id' => $product->getKey(),
            'qty' => 10,
        ];

        $this->postJson($this->endpointCheckout, $data)
            ->assertStatus(200);
    }

    /**
     * Test Create endpoint if out of stock.
     *
     * @return void
     */
    public function testCheckoutEndpointValidationStockExpected()
    {
        $product = Product::find(1);

        $data = [
            'product_id' => $product->getKey(),
            'qty' => 1000,
        ];

        $this->postJson($this->endpointCheckout, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['qty']);
    }

    /**
     * Test endpoint when checkout and paid.
     *
     * @return void
     */
    public function testEndpontWhenCheckoutandPaid()
    {
        $users = 100; // it's asume the checkout

        for ($i = 0; $i < $users; $i++) {
            $product = Product::find(1);
            $items = 50; // it's asume the user buy 20 items

            $request = [
                'product_id' => $product->getKey(),
                'qty' => $items,
            ];

            $responseCheckout = $this->postJson($this->endpointCheckout, $request);

            if ($product->stock > 0) { // if stock available
                $responseCheckout->assertStatus(200);
            } else {
                $responseCheckout->assertStatus(422);
                $responseCheckout->assertJsonValidationErrors(['qty']);
            }

            //test
            $request = [
                'products' => [
                    [
                        'id' => $product->getKey(),
                        'qty' => $items,
                    ],
                ],
            ];

            $responsePayment = $this->postJson($this->endpointPayment, $request);

            if ($product->stock > 0) { // if stock available
                $responsePayment->assertStatus(200);
            } else {
                $responsePayment->assertStatus(422);
                $responsePayment->assertJsonValidationErrors(['products.0.qty']);
            }
        }
    }
}
