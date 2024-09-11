<?php

namespace App\repositories;

use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentRepository
{
    public function createPaymentIntent($request)
    {
        try {
            // Set your Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Create a PaymentIntent with the given amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => $request->currency,
                // Optionally, you can add other metadata
                'metadata' => [
                    'order_id' => '1234'
                ]
            ]);

            // Return the PaymentIntent client secret
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }
}