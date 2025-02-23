<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentSetting;

class PaymentSettingController extends Controller
{
    
    public function index()
    {
        $paymentSettings = PaymentSetting::first();
        return view('payment_method.index', compact('paymentSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'stripe_public_key' => 'required',
            'stripe_secret_key' => 'required',
            // 'stripe_webhook_secret' => 'nullable|string',
        ]);
        // dd($request);

        $paymentSettings = PaymentSetting::firstOrCreate([]);
        $paymentSettings->update($request->all());

        return back()->with('success', 'Payment settings updated successfully.');
    }
}
