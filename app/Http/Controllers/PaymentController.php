<?php

namespace App\Http\Controllers;

use App\repositories\PaymentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentController extends Controller
{
    protected $payment;

    public function __construct(PaymentRepository $payment)
    {
        $this->payment = $payment;
    }
    public function createPaymentIntent(Request $request): JsonResponse
    {
        return $this->payment->createPaymentIntent($request);
    }
}
