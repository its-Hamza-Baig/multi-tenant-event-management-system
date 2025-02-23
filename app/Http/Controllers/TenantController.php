<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(){
        $data = Tenant::with('domains', 'subscription.plan')->get();
        return view('tenants.index', compact('data'));
    }
}
