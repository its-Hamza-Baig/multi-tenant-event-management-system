<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Log;

class PaymentSettingController extends Controller
{
    
    public function index()
    {
        $paymentSettings = PaymentSetting::first();
        return view('payment_method.index', compact('paymentSettings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'stripe_public_key' => 'required',
            'stripe_secret_key' => 'required',
            // 'stripe_webhook_secret' => 'nullable|string',
        ]);
        // dd($request);

        
        try {
             
            $paymentSettings = PaymentSetting::firstOrCreate([]);

             $paymentSettings->update([
                'stripe_public_key' => $validatedData['stripe_public_key'],
                'stripe_secret_key' => $validatedData['stripe_secret_key'],
            ]);

            return back()->with('success', 'Payment settings updated successfully.');
        } catch (Exception $e) {
             
            Log::error('Payment settings update failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to update payment settings. Please try again.');
        }
    }
}
