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
        $data = Event::findOrFail($id);
        
        $keys = $this->getPaymentSettings();

        if (!$this->checkAvailability($data)) {
            return back()->with('error', 'Sorry, All the Seats are already reserved');
        }
          
        return view('app.booking.create', compact('data', 'keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
            'event_id' => 'required'
        ]);

        $event = Event::findOrFail($request->event_id);
        
       
        if (!$this->checkAvailability($event)) {
            return back()->with('error', 'Sorry, All the Seats are already reserved');
        }
        
        $paymentSettings = $this->getPaymentSettings();


 
        try {

            Stripe::setApiKey($paymentSettings->stripe_secret_key);

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
        $event = Event::findOrFail($id);
       
        if (!$this->checkAvailability($event)) {
            return back()->with('error', 'Sorry, All the Seats are already reserved');
        }

        Booking::create([
            'user_id' => auth()->user()->id,
            'event_id' => $id
        ]);
        return redirect()->back()->with('success', 'event booked');
    }

    public function myBookings()
    {
        $data = Booking::with('event')->where('user_id', auth()->id)->get();
        return view('app.booking.index', compact('data'));
    }

    

    private function getPaymentSettings()
    {
        $settings = PaymentSetting::first();
        abort_if(!$settings, 500, 'Payment settings not configured.');
        
        return $settings;
    }

    private function checkAvailability(Event $event)
    {
        return $event->capacity > Booking::where('event_id', $event->id)->count();
    }
}
