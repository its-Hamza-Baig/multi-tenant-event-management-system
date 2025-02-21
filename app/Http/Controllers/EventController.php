<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $events = Event::where('user_id', auth()->user()->id)->get(); 
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
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
        ]);

        try{

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
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

        return view('events.edit', compact('event'));
        
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
            'end_time'    => 'required|date_format:H:i|after:start_time',
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
