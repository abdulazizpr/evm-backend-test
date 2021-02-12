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
    public function checkout($request): Order
    {
        $model = $this->model->create();

        $model->orderItems()->create([
            'product_id' => $request->product_id,
            'name' => $request->product->name,
            'price' => $request->product->price,
            'qty' => $request->qty,
            'subtotal' => $request->qty * $request->product->price,
        ]);

        $model->proccessCheckout();

        return $model;
    }
}