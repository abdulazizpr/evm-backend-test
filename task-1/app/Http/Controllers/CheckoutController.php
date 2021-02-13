<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    /**
     * Create checkout to order
     *
     * @param CheckoutRequest $request
     *
     * @return \Illuminate\Http\JsonResponse;
    */
    public function create(CheckoutRequest $request): JsonResponse
    {
        return new JsonResponse([
            'status' => 200,
            'message' => 'Checkout is success',
            'data' => [
                'product' => [$request->product],
            ],
        ], 200);
    }
}
