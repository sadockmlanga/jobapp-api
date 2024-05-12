<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentService
{
    protected $stripeSecretKey;

    public function __construct()
    {
        $this->stripeSecretKey = config('services.stripe.secret');
        Stripe::setApiKey($this->stripeSecretKey);
    }

    /**
     * Initiate a payment using Stripe PaymentIntent.
     *
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @return PaymentIntent
     */
    public function initiatePayment(float $amount, string $currency, string $description): PaymentIntent
    {
        try {
            return PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
            ]);
        } catch (ApiErrorException $e) {
            // Handle errors gracefully
            throw $e;
        }
    }

    /**
     * Handle payment status updates.
     *
     * @param string $paymentIntentId
     * @return PaymentIntent
     */
    public function handlePaymentStatusUpdate(string $paymentIntentId): PaymentIntent
    {
        try {
            return PaymentIntent::retrieve($paymentIntentId);
        } catch (ApiErrorException $e) {
            // Handle errors gracefully
            throw $e;
        }
    }
}
