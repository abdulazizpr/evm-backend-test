<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    /**
     * The model depedency
     *
     * @var \App\Models\Order
    */
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * Create order
     *
     * @param mixed $order
     *
     * @return \App\Models\Order
    */
    public function payment($request): Order
    {
        $model = $this->model->create();

        foreach ($request->products as $product) {
            $model->orderItems()->create([
                'product_id' => $product['id'],
                'name' => $product['product']->name,
                'price' => $product['product']->price,
                'qty' => $product['qty'],
                'subtotal' => $product['qty'] * $product['product']->price,
            ]);
        }

        $model->proccessPayment();

        \Log::info('Proccess Payment for order ' . $model->order_number );

        return $model;
    }
}