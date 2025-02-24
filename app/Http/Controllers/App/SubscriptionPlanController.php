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

        $keys = $this->getPaymentSettings();
        $plan = $this->getPlanById($id);


        // $keys = PaymentSetting::on('central')->first();
 
        // dd($keys);
        return view('app.plans.subscribe', compact('plan','keys'));
    }

   
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'stripeToken' => 'required',
            'plan_id' => 'required|integer'
        ]);
 
        $paymentSettings = $this->getPaymentSettings();
        $plan = $this->getPlanById($validated['plan_id']);

 
        try {
            Stripe::setApiKey($paymentSettings->stripe_secret_key);

            $charge = Charge::create([
                'amount' => $plan->price * 100,  
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => "Subscription for {$plan->name}",
            ]);
            $this->storeSubscription($plan->id);
 
            return redirect()->route('dashboard')->with('success', 'Payment successful! Subscription activated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }



    private function getPaymentSettings()
    {
        $settings = DB::connection('central')->table('payment_settings')->first();
        abort_if(!$settings, 500, 'Payment settings not configured.');
        
        return $settings;
    }

     
    private function getPlanById($id)
    {
        $plan = DB::connection('central')->table('subscription_plans')->find($id);
        abort_if(!$plan, 404, 'Plan not found.');

        return $plan;
    }


    private function storeSubscription($planId)
    {
        $tenantId = tenant()->id;
 
        DB::table('subscriptions')->updateOrInsert(
            ['tenant_id' => $tenantId],
            [
                'tenant_id'  => $tenantId,
                'plan_id'    => $planId,
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::connection('central')->table('tenant_subscriptions')->updateOrInsert(
            ['tenant_id' => $tenantId],
            [
                'plan_id'       => $planId,
                'status'        => 'active',
                'subscribed_at' => now(),
                'updated_at'    => now(),
            ]
        );
    }
}
