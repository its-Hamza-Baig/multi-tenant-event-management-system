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

        if (!$subscription || $subscription->plan->event_limit <= Event::count()) {
            return redirect()->route('dashboard')->with('error', $subscription ? 'Event creation limit reached.' : 'You must subscribe to a plan.');
        }

        return $next($request);
    }
}
