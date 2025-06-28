<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Orders;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function($row){
                    $name = $row->name ?? '';
                    $lastName = $row->last_name ?? '';
                    return trim($name . ' ' . $lastName);
                })
                ->addColumn('created_at', function($row){
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($row){
                    // $btn = '<a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a> &nbsp;';
                    $btn = '<button data-id="'.$row->id.'" data-toggle="modal" data-target="#confirmDeleteModal" class="btn btn-danger btn-sm deleteData">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action','name'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function destroy(User $user)
    {
        $uid = $user->id;
        $user->delete();

        Address::where('user_id',$uid)->delete();
        Orders::where('user_id',$uid)->delete();

        return response()->json(['message' => 'Item deleted successfully'], 200);
    }

    public function get_order_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Orders::with(['product','user'])->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('product_name', function($row){
                    $name = $row->product->name ?? '';
                    return trim($name);
                })

                ->addColumn('user_name', function($row){
                    $name = $row->user->name ?? '';
                    return trim($name);
                })

                ->addColumn('status', function($row){
                    $currentStatus = $row->status ?? '';
                    $statusOptions = ['pending','processing','shipped','cancelled','partially_shipped','delivered','partially_delivered','payment_captured'];

                    $html = '<select class="form-control order-status-dropdown" data-id="' . $row->id . '">';
                    foreach ($statusOptions as $status) {
                        $selected = $currentStatus === $status ? 'selected' : '';
                        $html .= "<option value=\"$status\" $selected>$status</option>";
                    }
                    $html .= '</select>';
                    return $html;
                })

                ->addColumn('created_at', function($row){
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })              
                ->rawColumns(['product_name','user_name','status'])
                ->make(true);
        }
        return view('admin.users.order_index');
    }

    public function change_order_status(Request $request)     //  change order status
    {
        $order = Orders::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => 'Order status updated.']);
        
        // $token = $this->getShiprocketToken(); // Helper function to get token
        // $order = Orders::findOrFail($request->id);
        // if($order){

        //     $order->shiprocket_shipment_id = 12;
        //     $response = Http::withToken($token)->get(
        //         "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/{$order->shiprocket_shipment_id}"
        //     );
        //     $responseData = $response->json();
        //     $data = $responseData[$order->shiprocket_shipment_id];

        //     if (!empty($data)) {
        //         $order->update([
        //             'status' => $data['tracking_data']['shipment_status']['shipment_track'][0]['current_status'] ?? 'Unknown',
        //             'shipment_status' => $data['tracking_data']['shipment_status'] ?? 'Unknown',
        //             'shipment_tracking_history' => json_encode($data['tracking_data']['shipment_track'] ?? []),
        //         ]);
        //         // $this->info("Updated order #{$order->id}");
        //         return "Updated order #{$order->id}";
        //     } else {
        //         // $this->warn("Failed to fetch tracking for #{$order->id}");
        //         return "Failed to fetch tracking for #{$order->id}";   
        //     }
        // }
        // return Command::SUCCESS;
    }

    private function getShiprocketToken()
    {
        // $shiprocket = app(ShiprocketService::class);
        $shiprocket = new \App\Services\ShiprocketService();
        return $shiprocket->getToken(); // this refreshes and caches      
    }

}
