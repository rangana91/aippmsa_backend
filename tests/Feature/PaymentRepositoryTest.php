<?php

namespace Tests\Unit\Repositories;

use App\repositories\PaymentRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Tests\TestCase;

class PaymentRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $paymentRepository;

    public function setUp(): void
    {
        parent::setUp();

        // Initialize PaymentRepository
        $this->paymentRepository = new PaymentRepository();
    }

    /** @test */
    public function it_can_create_payment_intent()
    {
        // Mock request data
        $request = new Request([
            'amount' => 5000,
            'currency' => 'usd',
        ]);

        // Mock Stripe PaymentIntent creation
        $mockPaymentIntent = Mockery::mock('alias:' . PaymentIntent::class);

        $mockPaymentIntent->shouldReceive('create')
            ->once()
            ->with([
                'amount' => $request->amount,
                'currency' => $request->currency,
                'metadata' => [
                    'order_id' => '1234'
                ]
            ])
            ->andReturn((object)[
                'client_secret' => 'test_client_secret'
            ]);

        // Call the method in PaymentRepository
        $response = $this->paymentRepository->createPaymentIntent($request);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);

        $responseData = $response->getData();
        $this->assertEquals('test_client_secret', $responseData->clientSecret);
    }

    /** @test */
    public function it_handles_payment_intent_creation_exception()
    {
        // Mock request data
        $request = new Request([
            'amount' => 5000,
            'currency' => 'usd',
        ]);

        $mockPaymentIntent = Mockery::mock('alias:' . PaymentIntent::class);
        $mockPaymentIntent->shouldReceive('create')
            ->once()
            ->andThrow(new \Exception('Payment intent creation failed'));

        $response = $this->paymentRepository->createPaymentIntent($request);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);

        $responseData = $response->getData();

        $this->assertEquals('Payment intent creation failed', $responseData->error);

        $this->assertEquals(500, $response->getStatusCode());
    }
}

