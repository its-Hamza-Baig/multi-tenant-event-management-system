<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventObserver
{
    
    public function creating(Event $event)
    {
        if (Auth::check()) {
            $event->user_id = Auth::id();
        }
    }

     
    public function updating(Event $event)
    {
        if (Auth::check() && !$event->isDirty('user_id')) {
            $event->user_id = Auth::id();
        }
    }
}
