<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use Illuminate\Support\Facades\Cache;

class ExternalCatalogs
{
    /**
     * Handle an incoming request.
     * Load and cache External API calls
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Cache::has('country_codes')) {
            try {
                $arr = json_decode(
                    file_get_contents('https://api.hostaway.com/countries'),
                    true
                );
                Cache::put('country_codes', $arr['result'], env('CACHE_EXPIRE'));
				Log::info('Cache: `country_codes` updated');
            } catch (\Exception $e) {
                exit('Something went wrong. '.$e->getMessage());
            }
        }
        if (!Cache::has('timezones')) {
            try {
                $arr = json_decode(
                    file_get_contents('https://api.hostaway.com/timezones'),
                    true
                );
                Cache::put('timezones', $arr['result'], env('CACHE_EXPIRE'));
				Log::info('Cache: `timezones` updated');
            } catch (\Exception $e) {
				Log::error('Cache: `timezones` update error. '.$e->getMessage());
                exit('Something went wrong. '.$e->getMessage());
            }
        }
        return $next($request);
    }
}
