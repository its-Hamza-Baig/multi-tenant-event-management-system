<?php

namespace App\Http\Controllers\App;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $events = Event::with('bookings')->get(); 
        return view('app.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $subscription = tenant()->subscription;
        $attendeeLimit = $subscription ? $subscription->plan->attendee_limit : 100;
        return view('app.events.create', compact('attendeeLimit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'capacity'    => 'required|integer|min:1',
            'event_type' => 'required|in:free,paid',
            'price' => 'nullable|required_if:event_type,paid|numeric|min:0',
        ]);

        try{

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
                'event_type' => $request->event_type,
                'price' => $request->event_type === 'paid' ? $request->price : 0,
            ]);
    
            return redirect()->route('events.index')->with('success', 'Event Created Successfully!');
        } catch(\Exception $e){
            Log::error('Error creating event'. $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong! Please try again.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // dd($event);

        return view('app.events.edit', compact('event'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
       
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'capacity'    => 'required|integer|min:1',
        ]);

        try {
          
            $event->update([
                'title'       => $request->title,
                'description' => $request->description,
                'start_time'  => $request->start_time,
                'end_time'    => $request->end_time,
                'capacity'    => $request->capacity,
            ]);

            return redirect()->route('events.index')->with('success', 'Event Updated Successfully!');
        } catch (\Exception $e) {
             
            Log::error('Error updating event: ' . $e->getMessage());

             return redirect()->back()->withInput()->with('error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        
        // dd($event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event Deleted Successfully!');
    }
}
