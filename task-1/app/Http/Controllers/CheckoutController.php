<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * The order repository depedency
     *
     * @var \App\Repositories\OrderRepository
    */
    protected $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app(OrderRepository::class);
    }

    /**
     * Create checkout to order
     *
     * @param CheckoutRequest $request
     *
     * @return \Illuminate\Http\JsonResponse;
    */
    public function create(CheckoutRequest $request): JsonResponse
    {
        try {
            $order = $this->orderRepo->checkout($request);

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollback();

            return new JsonResponse([
                'status' => 500,
                'message' => 'Checkout is failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'status' => 200,
            'message' => 'Checkout is success',
            'data' => $order,
        ], 200);
    }
}