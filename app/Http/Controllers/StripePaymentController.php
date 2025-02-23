<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class StripePaymentController extends Controller
{
    
    public function showPaymentForm()
    {
        $stripeKey = Config::get('services.stripe.key');

        // dd($stripeKey);
        if (!$stripeKey) {
            return redirect()->back()->with('error', 'Please set up your Stripe API keys first.');
        }

        return view('stripe.payment-form', ['stripe_key' => $stripeKey]);
    }

    public function processPayment(Request $request)
    {
        $stripeSecret = Config::get('services.stripe.secret');

        if (!$stripeSecret) {
            return redirect()->route('api_keys.form')->with('error', 'Stripe secret key is missing.');
        }

        Stripe::setApiKey($stripeSecret);

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment from Laravel App',
            ]);

            return back()->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
