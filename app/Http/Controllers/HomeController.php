<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class HomeController extends Controller
{
    
    public function index()
    {
        
        $plans = SubscriptionPlan::all();
        return view('welcome', compact('plans'));
    }

     
    public function create()
    {
        //
    }

     
    public function store(Request $request)
    {
        //
    }

     
    public function show(string $id)
    {
        //
    }

     
    public function edit(string $id)
    {
        //
    }

     
    public function update(Request $request, string $id)
    {
        //
    }

     
    public function destroy(string $id)
    {
        //
    }
}
