<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShiprocketService
{
    public function getToken()
    {
        if (Cache::has('shiprocket_token')) {
            return Cache::get('shiprocket_token');
        }
        $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
            'email' => config('services.shiprocket.email'),
            'password' => config('services.shiprocket.password')
        ]);

        $token = $response['token'];
        Cache::put('shiprocket_token', $token, now()->addHours(23)); // Cache for 23h
        return $token;
    }
}

?>