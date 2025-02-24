<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Database\QueryException;

class SubscriptionPlanController extends Controller
{
    
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    
    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        try {
            SubscriptionPlan::create($validatedData);
            return redirect()->route('plans.index')->with('success', 'Subscription Plan Created Successfully.');
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: Failed to create Subscription Plan.');
        } catch (Exception $e) {
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('plans.show', compact('subscriptionPlan'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        // dd($subscriptionPlan);
        return view('plans.edit', compact('subscriptionPlan'));
    }

    
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validatedData = $this->validateRequest($request);

        try {
            $subscriptionPlan->update($validatedData);
            return redirect()->route('plans.index')->with('success', 'Subscription Plan Updated Successfully.');
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: Failed to update Subscription Plan.');
        } catch (Exception $e) {
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        try {
            $subscriptionPlan->delete();
            return redirect()->route('plans.index')->with('success', 'Subscription Plan Deleted Successfully.');
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: Failed to delete Subscription Plan.');
        } catch (Exception $e) {
            return back()->with('error', 'An unexpected error occurred.');
        }
    }



    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name'            => 'required|string|max:255',
            'price'           => 'required|numeric|min:0',
            'event_limit'     => 'nullable|integer|min:0',
            'attendee_limit'  => 'nullable|integer|min:0',
            'seat_maps'       => 'boolean',
            'discount_codes'  => 'boolean',
        ]);
    }
}
