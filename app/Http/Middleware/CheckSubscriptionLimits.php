<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Event;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();
        $subscription = $tenant->subscription;

        if (!$subscription) {
            return redirect()->route('dashboard')->with('error', 'You must subscribe to a plan.');
        }

        // Get event limits from plan
        $plan = $subscription->plan;
        $currentEventCount = Event::count(); // Count total events created by the tenant

        // Check event limit
        if ($currentEventCount >= $plan->event_limit) {
            return redirect()->back()->with('error', 'Event creation limit reached.');
        }

        return $next($request);
    }
}
