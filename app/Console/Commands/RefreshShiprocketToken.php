<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
// use App\Services\ShiprocketService;

class RefreshShiprocketToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-shiprocket-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //  if (Cache::has('shiprocket_token')) {
        //     return Cache::get('shiprocket_token');
        // }

        // $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
        //     'email' => config('services.shiprocket.email'),
        //     'password' => config('services.shiprocket.password')
        // ]);

        // $token = $response['token'];
        // Cache::put('shiprocket_token', $token, now()->addHours(23)); // Cache for 23h
        // return $token;

        // get token using service
        $shiprocket = new \App\Services\ShiprocketService();
        $shiprocket->getToken(); // this refreshes and caches
    }
}
