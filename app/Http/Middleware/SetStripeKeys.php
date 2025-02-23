<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class SetStripeKeys
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $keys = null;
        // dd($this->isMainDomain(), request()->getHost());
        if ($this->isMainDomain()) {
            // Main domain (super admin), get Stripe keys from super admin DB
            $keys = PaymentSetting::first();
            // dd($keys);
        } else {
            // Tenant domain, get tenant-specific Stripe keys
            // $tenant = app(DomainTenantResolver::class)->resolve($request->getHost());
            // $keys = $tenant ? $tenant->paymentSettings()->first() : null;
        }

        if ($keys) {
            Config::set('services.stripe.key', $keys->stripe_public_key);
            Config::set('services.stripe.secret', $keys->stripe_secret_key);
        }

        return $next($request);
    }

    private function isMainDomain()
    {
        return in_array(request()->getHost(), config('tenancy.central_domains', []));
    }
}
