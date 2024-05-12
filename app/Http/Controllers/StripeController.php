<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\Stripe as StripeGateway;

use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function createCheckoutSession(Request $request)
    {
        $userID = Auth::id();
        
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Premium Job Posting Package',
                        ],
                        'unit_amount' => 10000, // Amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8080/success', 
            'cancel_url' => 'http://127.0.0.1:8080', 
            'client_reference_id' => $userID,
        ]);

        return response()->json(['id' => $session->id]);
    }


    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );

            // Handling the event
            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;
                
                // Identifing the user
                $userId = $session->client_reference_id;
                $user = User::find($userId);

                if ($user) {
                    $user->update([
                        'subscribed' => true,
                    ]);
                }
                
            return response()->json(['success' => true]);
        } 
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }




}
