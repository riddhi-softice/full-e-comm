<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Orders;
// use App\Services\ShiprocketService;

class TrackShiprocketShipments extends Command
{
    protected $signature = 'shiprocket:track';
    protected $description = 'Update order tracking status from Shiprocket';

    public function handle()
    {
        $token = $this->getShiprocketToken(); // Helper function to get token
        $orders = Orders::whereNotNull('shiprocket_shipment_id')->where('status', '!=', 'Delivered')->get();

        foreach ($orders as $order) {
            // $order->shiprocket_shipment_id = 12;

            $response = Http::withToken($token)->get(
                "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/{$order->shiprocket_shipment_id}"
            );
            $responseData = $response->json();
            $data = $responseData[$order->shiprocket_shipment_id];

            if (!empty($data)) {
                $order->update([
                    'shipment_status' => $data['tracking_data']['shipment_status'] ?? 'Unknown',
                    'shipment_tracking_history' => json_encode($data['tracking_data']['shipment_track'] ?? []),
                ]);
                // $this->info("Updated order #{$order->id}");
                return "Updated order #{$order->id}";
            } else {
                // $this->warn("Failed to fetch tracking for #{$order->id}");
                return "Failed to fetch tracking for #{$order->id}";   
            }
        }
        return Command::SUCCESS;
    }

    private function getShiprocketToken()
    {
       // get token using service
        $shiprocket = new \App\Services\ShiprocketService();
        $shiprocket->getToken(); // this refreshes and caches
    }

}
