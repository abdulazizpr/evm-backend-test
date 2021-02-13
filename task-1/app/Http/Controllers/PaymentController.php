<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Repositories\OrderRepository;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
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
    public function create(PaymentRequest $request){
        \DB::beginTransaction();

        try {
            $order = $this->orderRepo->payment($request);

            \DB::commit();
        } catch (Throwable $e) {
            \DB::rollback();

            return new JsonResponse([
                'status' => 500,
                'message' => 'Payment is failed',
            ], 500);
        }

        return new JsonResponse([
            'status' => 200,
            'message' => 'Payment is success',
            'data' => [
                'order' => $order,
            ],
        ], 200);
    }
}