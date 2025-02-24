<?php

namespace App\Http\Controllers\App;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
     
    public function index()
    {
        
        $events = Event::with('bookings')->get(); 
        return view('app.events.index', compact('events'));
    }

    
    public function create()
    { 
        $attendeeLimit = tenant()->subscription?->plan->attendee_limit ?? 100;

        return view('app.events.create', compact('attendeeLimit'));
    }
 
    public function store(Request $request)
    {
        $validatedData = $this->validateEvent($request);
        return $this->saveEvent(new Event(), $validatedData, 'Event Created Successfully!');        
    }

   
    public function show(string $id)
    {
        //
    }

    
    public function edit(Event $event)
    {
 
        return view('app.events.edit', compact('event'));
        
    }

     
    public function update(Request $request, Event $event)
    {
       
        $validatedData = $this->validateEvent($request, false);

        return $this->saveEvent($event, $validatedData, 'Event Updated Successfully!');

    }

     
    public function destroy(Event $event)
    {
        
        // dd($event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event Deleted Successfully!');
    }
    private function validateEvent(Request $request, $isNew = true)
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i',
            'capacity'    => 'required|integer|min:1',
            'event_type'  => $isNew ? 'required|in:free,paid' : '',
            'price'       => $isNew ? 'nullable|required_if:event_type,paid|numeric|min:0' : '',
        ]);
    }


    private function saveEvent(Event $event, array $data, string $message)
    {
        try {
            $data['price'] = $data['event_type'] === 'paid' ? ($data['price'] ?? 0) : 0;
            $event->fill($data)->save();

            return redirect()->route('events.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error("Error saving event: {$e->getMessage()}");
            return redirect()->back()->withInput()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
