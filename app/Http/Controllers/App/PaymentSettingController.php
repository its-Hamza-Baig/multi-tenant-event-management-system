<?php

namespace App\Http\Controllers\App;

use Exception;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentSettingController extends Controller
{
    
    public function index()
    {
        $paymentSettings = PaymentSetting::first();
        
        return view('app.payment_method.index', compact('paymentSettings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'stripe_public_key' => 'required',
            'stripe_secret_key' => 'required',
         ]);
 
        
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
