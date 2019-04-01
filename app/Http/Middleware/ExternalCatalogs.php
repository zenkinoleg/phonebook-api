<?php

namespace App\Http\Middleware;

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
        if (!Cache::has('country_codes', 0)) {
            try {
                $arr = json_decode(
                    file_get_contents('https://api.hostaway.com/countries'),
                    true
                );
                Cache::put('country_codes', $arr['result']);
            } catch (\Exception $e) {
                exit('Something went wrong. '.$e->getMessage());
            }
        }
        if (!Cache::has('timezones', 0)) {
            try {
                $arr = json_decode(
                    file_get_contents('https://api.hostaway.com/timezones'),
                    true
                );
                Cache::put('timezones', $arr['result']);
            } catch (\Exception $e) {
                exit('Something went wrong. '.$e->getMessage());
            }
        }
        return $next($request);
    }
}