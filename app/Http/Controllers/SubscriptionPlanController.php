<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'event_limit' => 'required|integer|min:0',
            'attendee_limit' => 'required|integer|min:0',
            'seat_maps' => 'boolean',
            'discount_codes' => 'boolean',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('subscription-plans.index')->with('success', 'Subscription Plan Created Successfully.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'event_limit' => 'nullable|integer|min:0',
            'attendee_limit' => 'nullable|integer|min:0',
            'seat_maps' => 'boolean',
            'discount_codes' => 'boolean',
        ]);

        $subscriptionPlan->update($request->all());

        return redirect()->route('subscription-plans.index')->with('success', 'Subscription Plan Updated Successfully.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscription-plans.index')->with('success', 'Subscription Plan Deleted Successfully.');
    }
}
