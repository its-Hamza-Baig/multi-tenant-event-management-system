<?php

namespace App\Http\Controllers;
 
use Exception;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rules\Password;

class TenantRegisterController extends Controller
{
    public function register(Request $request){
       
        return view('auth.tenant-register');
    }

    public function store(Request $request){
        

        $validatedData = $this->validateRequest($request);


        try {
            $validatedData['role'] = 'admin';
 
            $tenant = Tenant::create($validatedData);
 
            $tenant->domains()->create([
                'domain' => $validatedData['domain_name'] . '.' . config('app.domain'),
            ]);

            return redirect()->route('tenant.register')->with('success', 'Your organization has been registered successfully. You can now log in using your domain name.');

        } catch (QueryException $e) {
            return back()->with('error', 'Database error: Unable to register your organization.');
        } catch (Exception $e) {
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }

   

    }


    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:tenants,email',
            'domain_name'  => 'required|string|max:255|unique:domains,domain',
            'password'     => ['required', 'confirmed', Password::defaults()],
        ]);
    }
}
