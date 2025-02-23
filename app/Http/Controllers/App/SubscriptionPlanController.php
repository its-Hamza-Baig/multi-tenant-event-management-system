<?php

namespace App\Http\Controllers\App;

use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubscriptionPlanController extends Controller
{
    
    public function index()
    {
        $plans = DB::connection('central')->table('subscription_plans')->get();
        return view('app.plans.index', compact('plans'));
    }

    public function subscribe($id)
    {

        $keys = PaymentSetting::on('central')->first();
        if($id){
            $plan = DB::connection('central')->table('subscription_plans')->where('id', $id)
            ->first();

        }
        // dd($keys);
        return view('app.plans.subscribe', compact('plan','keys'));
    }

   
    public function processPayment(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
            'plan_id' => 'required'
        ]);

        // Fetch Stripe keys from the central database
        $paymentSettings = DB::connection('central')->table('payment_settings')->first();
        if (!$paymentSettings) {
            return redirect()->back()->with('error', 'Payment settings not configured.');
        }

        Stripe::setApiKey($paymentSettings->stripe_secret_key);

        // Fetch the selected plan details
        $plan = DB::connection('central')->table('subscription_plans')->where('id', $request->plan_id)->first();
        if (!$plan) {
            return redirect()->back()->with('error', 'Plan not found.');
        }

        try {
            $charge = Charge::create([
                'amount' => $plan->price * 100, // Convert to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => "Subscription for {$plan->name}",
            ]);


            // Store the subscription in the tenant database
            DB::table('subscriptions')->insert([
                'tenant_id' => tenant()->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store the subscription in the central database (for super admin tracking)
            DB::connection('central')->table('tenant_subscriptions')->updateOrInsert(
                ['tenant_id' => tenant()->id],
                [
                    'plan_id' => $plan->id,
                    'status' => 'active',
                    'subscribed_at' => now(),
                    'updated_at' => now(),
                ]
            );

            return redirect()->route('dashboard')->with('success', 'Payment successful! Subscription activated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
