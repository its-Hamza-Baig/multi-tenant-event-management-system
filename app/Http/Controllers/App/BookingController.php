<?php

namespace App\Http\Controllers\App;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($id)
    {
        $data = Event::find($id);
        $keys = PaymentSetting::first();

        if(!$keys){
            return redirect()->back()->with('error', 'Sorry, Payment settings not configured.');
        }
         
        
        $booked = Booking::where('event_id', $data->id)->count();
         
        $available = $data->capacity - $booked;
        if($available == 0){
            return redirect()->back()->with('error', 'Sorry, All the Seats are already reserved');
        }



        return view('app.booking.create', compact('data', 'keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
            'event_id' => 'required'
        ]);

        $event = Event::find($request->event_id);
        
        $booked = Booking::where('event_id', $request->event_id)->count();
         
        $available = $event->capacity - $booked;
        if($available == 0){
            return redirect()->back()->with('error', 'Sorry, All the Seats are already reserved');
        }


        $paymentSettings = PaymentSetting::first();
        if (!$paymentSettings) {
            return redirect()->back()->with('error', 'Payment settings not configured.');
        }

        Stripe::setApiKey($paymentSettings->stripe_secret_key);
 
        try {
            $charge = Charge::create([
                'amount' => $event->price * 100,  
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => "Subscription for {$event->title}",
            ]);

            Booking::create([
                'user_id' => auth()->user()->id,
                'event_id' => $event->id
            ]);

            return redirect()->route('dashboard')->with('success', 'Payment successful! Event Subscribed.');
        } catch (\Exception $e) {
            Log::error('Payment failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function freeBooking($id)
    {
        $booked = Booking::where('event_id', $id)->count();
        $event = Event::find($id);
        $available = $event->capacity - $booked;
        if($available == 0){
            return redirect()->back()->with('error', 'Sorry, All the Seats are already reserved');
        }
        Booking::create([
            'user_id' => auth()->user()->id,
            'event_id' => $id
        ]);
        return redirect()->back()->with('success', 'event booked');
    }

    public function myBookings()
    {
        $data = Booking::with('event')->where('user_id', auth()->user()->id)->get();
        return view('app.booking.index', compact('data'));
    }
}
