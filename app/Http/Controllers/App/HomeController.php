<?php

namespace App\Http\Controllers\App;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data = Event::with('bookings')  
            ->withCount('bookings')  
            // ->where('start_time', '>', now())  
            ->having('bookings_count', '<', DB::raw('capacity'))  
            ->get();

        // dd($data);

        return view('app.welcome', compact('data'));
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
