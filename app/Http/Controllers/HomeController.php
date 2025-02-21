<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = Event::all();
        return view('welcome', compact('data'));
    }
 
}
