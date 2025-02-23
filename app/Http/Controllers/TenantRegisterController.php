<?php

namespace App\Http\Controllers;
 
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Validation\Rules\Password;

class TenantRegisterController extends Controller
{
    public function register(Request $request){
        if($request->query('plan_id')){
            $plans = SubscriptionPlan::find($request->plan_id);
        }else{
            $plans = SubscriptionPlan::all();
        }
        return view('auth.tenant-register', compact('plans'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'domain_name' => 'required|string|max:255|unique:domains,domain',
            'password' => ['required', 'confirmed', Password::defaults()], 
        ]);

        // dd($request);
        $validatedData['role'] = 'admin';
        $tenant = Tenant::create($validatedData);
        $tenant->domains()->create([
            'domain' => $validatedData['domain_name'].'.'.config('app.domain'),
        ]);

        return redirect()->route('tenant.register')->with('success', 'Your Organization has been registered successfully. Now you can be able to login to your domain name. ');
    }
}
