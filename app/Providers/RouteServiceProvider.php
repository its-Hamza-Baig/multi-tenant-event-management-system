<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $centralDomains = $this->centralDomains();
        // dd($centralDomains);
        $this->routes(function () use($centralDomains) {
            if ($this->isCentralDomain(request()->getHost(), $centralDomains)) {
                
                foreach ($centralDomains as $domain) {
                    Route::middleware('api')
                        ->prefix('api')
                        ->domain($domain)
                        ->group(base_path('routes/api.php'));
    
                    Route::middleware('web')
                        ->domain($domain)
                        ->group(base_path('routes/web.php'));
                }
            } else {
                // Tenant Users Access These Routes
                Route::middleware('web')
                    ->domain(request()->getHost()) // Any tenant domain
                    ->group(base_path('routes/tenant.php')); 
            }
        });
    }

    protected function isCentralDomain($currentDomain, array $centralDomains): bool
    {
        return in_array($currentDomain, $centralDomains);
    }
    protected function centralDomains(): array 
    {
        return config('tenancy.central_domains', []);
    }
}
