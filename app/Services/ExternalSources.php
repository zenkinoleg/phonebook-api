<?php

namespace App\Services;

use Log;
use Illuminate\Support\Facades\Cache;

class ExternalSources
{
    public static function getCountries(?bool $force = false)
    {
        if (!$force && Cache::has('isoCountries')) {
            return Cache::get('isoCountries');
        }
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', env('ISO_HOST') . '/countries');
            $arr = json_decode($response->getBody(), true);
            Cache::put('isoCountries', $arr['result'], env('CACHE_EXPIRE'));
            Log::info('Cache: `isoCountries` updated');
        } catch (\Exception $e) {
			$message = 'Problem loading `isoCountries`: ' . $e->getMessage();
            Log::error($message);
            throw new \Exception($message);
        }
        return Cache::get('isoCountries');
    }

    public static function getTimezones(?bool $force = false)
    {
        if (!$force && Cache::has('isoTimezones')) {
            return Cache::get('isoTimezones');
        }
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', env('ISO_HOST') . '/timezones');
            $arr = json_decode($response->getBody(), true);
            Cache::put('isoTimezones', $arr['result'], env('CACHE_EXPIRE'));
            Log::info('Cache: `isoTimezones` updated');
        } catch (\Exception $e) {
			$message = 'Problem loading `isoTimezones`: ' . $e->getMessage();
            Log::error($message);
            throw new \Exception($message);
        }
        return Cache::get('isoTimezones');
    }
}
