<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Razorpay\Api\Api;
use Session;
use Exception;
use DB;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        $uid = auth()->id();
        $user = User::with('address')->where('id',$uid)->first();
        // $data['product_details'] = Product::where('id',$productId)->select('id','name','price')->first();

        $ip = request()->ip();
        $country = 'Unknown';
        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {}

        $country = 'india';
        $isIndia = strtolower($country) === 'india';
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value') ?? 85;
        $amount = 0;

        $getCart = CartItem::where('user_id',$uid)->get();
        foreach ($getCart as $key => $value) {       
            $product = Product::where('id',$value->product_id)->select('id','name','price')->first();
            $subTotal = $product->price * $value->quantity;

            $price = $isIndia ? round($subTotal * $usdRate , 2) : $subTotal;
            $product->display_price = $price;
            $product->quantity = $value->quantity;

            $amount =  $amount + $price; // Razorpay expects amount in paise/cents
            $product_list[] = $product;
        }
        
        $currency = $isIndia ? 'INR' : 'USD';
        $data = [
            'product_list' => $product_list,
            'user_details' => $user,
            'currency' => $currency,
            'total' => $amount,
            'pay_amount' => intval($amount * 100),
            'country' => $country,
        ];
        return view('web.order.add_order', compact('data'));
    }

    public function placeOrder(Request $request)
    {
        // dd($request->all());
        $uid = auth()->id();
        if (is_null($uid)) {
            throw new \Exception('Failed to featch user');
        }else{
            $user = User::where('id',$uid)->first();
            $inputUser = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ];
            $user->update($inputUser);
        }

        $address = Address::where('user_id',$uid)->first();
        $inputAdd = [
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ];
        if (!is_null($address)) {
            $address->update($inputAdd);
        }else {
            $inputAdd['user_id'] = $uid;
            Address::create($inputAdd);
        }
       
        // 1. Save order in local DB
        $order_num = "ORD".time(). rand(11,99);
        $order = Orders::create([
            'user_id'        => $uid,
            'order_num'      => $order_num,
            'total'          => $request->total,
            'payment_method' => 'RAZORPAY', // or COD
            'currency'       => $request->currency,
            'order_note'     => $request->order_note,
        ]);

        if($order){
            // Loop through product_ids and store in order_items
            foreach ($request->product_id as $index => $productId) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'user_id'    => $uid,
                    'product_id' => $productId,
                    // 'attribute_value_id' => ,
                    'price'      => $request->price[$index],
                    'quantity'   => $request->quantity[$index],
                ]);
            }

            // 2. Razorpay payment process
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            if(!empty($request->razorpay_payment_id)) {
               
                // remove cart item 
                CartItem::where('user_id',$uid)->delete();
                try {
                    $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=>$payment['amount']));
                    $order->update(['razorpay_payment_id' => $request->razorpay_payment_id ?? null]);
                
                        // 3. Authenticate with Shiprocket
                        $token = $this->getShiprocketToken();
                        // dd($token);
                        // $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company');
                        // $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup');
                        // dd($response->json());

                        $orderItems = [];
                        foreach ($request->product_id as $index => $productId) {
                            $product = Product::find($productId); // Or eager load in advance
                            $orderItems[] = [
                                "name"          => $product->name,
                                "sku"           => $product->slug ?? 'SKU' . $product->id,
                                "units"         => $request->quantity[$index],
                                "selling_price" => $request->price[$index],
                            ];
                        }

                        // 4. Create Shiprocket order
                        $shiprocketResponse = Http::withToken($token)->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
                            "order_id" => $order->id,
                            "order_date" => now()->format('Y-m-d'),
                            "pickup_location" => "Pickup Address", 
                            // "pickup_location" => "pickup_address", // Set in Shiprocket dashboard
                            "billing_customer_name" => $request->name,
                            "billing_address" => $request->street,
                            "billing_city" => $request->city,
                            "billing_pincode" => $request->postal_code,
                            "billing_state" => $request->state,
                            "billing_country" => $request->country,
                            "billing_email" => $request->email,
                            "billing_phone" => $request->phone,
                            "order_items" =>  $orderItems,
                            "payment_method" => "Prepaid",
                            "sub_total" => $request->total,
                            "length" => 10,
                            "breadth" => 10,
                            "height" => 5,
                            "weight" => 0.5
                        ]);
                        // dd($shiprocketResponse);
        
                        // Optional: save tracking/awb
                        if ($shiprocketResponse->successful()) {

                            $tracking = $shiprocketResponse['tracking_data']['track_url'] ?? null;
                            dd("here");
                            $order->update([
                                'status' => 'confirmed',
                                'shiprocket_shipment_id' => $shiprocketResponse['shipment_id'],
                                'awb_code' => $shiprocketResponse['awb_code'] ?? null,
                                'tracking_url' => $tracking,
                                // 'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
                            ]);
                        }
                        // dd("stop");
                    return redirect('/')->with('success', 'Order successfully.');
                } catch (Exception $e) {
                    return  $e->getMessage();
                    // Session::put('error',$e->getMessage());
                    return redirect()->back();
                }
            }else{
                return redirect()->back();
            }
        }
    }
    
    public function orderHistory(Request $request)
    {
        $uid = auth()->id();
        $orders = OrderItem::with(['product','product.firstImage','order'])->where('user_id',$uid)->latest()->get();
              
        $token = $this->getShiprocketToken();
        foreach ($orders as $value) {

            $order = $value->order;
            $order->shipment_id = "123";
            if ($order->shipment_id) {

                $response = Http::withToken($token)->get("https://apiv2.shiprocket.in/v1/external/courier/track/shipment/{$order->shipment_id}");
                if ($response->successful()) {

                    $trackingData = $response->json();
                    $value->tracking = $trackingData[$order->shipment_id]['tracking_data'] ?? null;
                } else {
                    $value->tracking = null;
                }
            } else {
                $value->tracking = null;
            }
        }
        $data['order_history'] = $orders;
        
        return view('web.order.order_history', compact('data'));
    }
   
    public function addOrderSingle(Request $request, $productId)
    {
        $uid = auth()->id();
        $user = User::with('address')->where('id',$uid)->first();
        // $data['product_details'] = Product::where('id',$productId)->select('id','name','price')->first();

        $ip = request()->ip();
        $country = 'Unknown';
        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ip}?fields=status,country");
            if ($response->ok() && $response['status'] === 'success') {
                $country = $response['country'];
            }
        } catch (\Exception $e) {}

        $isIndia = strtolower($country) === 'india';
        $usdRate = DB::table('common_settings')->where('setting_key', 'USD_price')->value('setting_value') ?? 85;

        $product = Product::where('id',$productId)->select('id','name','price')->first();
        $price = $isIndia ? round($product->price * $usdRate, 2) : $product->price ;
        $product->display_price = $price;
        $currency = $isIndia ? 'INR' : 'USD';
        $amount = intval($price * 100); // Razorpay expects amount in paise/cents

        $data = [
            'product_details' => $product,
            'user_details' => $user,
            'currency' => $currency,
            'amount' => $amount,
            'country' => $country,
        ];
        return view('web.order.single_add_order', compact('data'));
    }

    public function placeOrder_simple(Request $request)  
    {
        // dd($request->all());
        $uid = auth()->id();
        $user = User::where('id',$uid)->first();
        if (!is_null($user)) {
            $input = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ];
            $user->update($input);
        }
        $input1= [
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ];
        $address = Address::where('user_id',$uid)->first();
        if (!is_null($address)) {
            $address->update($input1);
        }else {
            $input1['user_id'] = $uid;
             Address::create($input1);
        }

        $product = Product::where('id',$request->product_id)->first();
        if (!is_null($product)) {
            $order_num = time(). "_" .rand();
            $input2 = [
                'user_id' => $uid,
                'order_num' => $order_num,
                'product_id' => $request->product_id,
                'total' => $request->total,
                'payment_method' => "COD",
                'order_note' => $request->order_note,
            ];
            Orders::create($input2);
        }
        return redirect('/')->with('success', 'Order successfully.');
    }

    public function placeOrder_single(Request $request)
    {
        // dd($request->all());
        $uid = auth()->id();
        if (is_null($uid)) {
            throw new \Exception('Failed to featch user');
        }else{
            $user = User::where('id',$uid)->first();
            $inputUser = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ];
            $user->update($inputUser);
        }

        $product = Product::where('id',$request->product_id)->first();
        if (is_null($product)) {
            throw new \Exception('Failed to featch product');
        }
        $inputAdd = [
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ];
        $address = Address::where('user_id',$uid)->first();
        if (!is_null($address)) {
            $address->update($inputAdd);
        }else {
            $inputAdd['user_id'] = $uid;
            Address::create($inputAdd);
        }

        // 1. Save order in local DB
        $order_num = "ORD".time(). rand(11,99);
        $order = Orders::create([
            'user_id' => $uid,
            'order_num' => $order_num,
            'product_id' => $request->product_id,
            'total' => $request->total,
            'payment_method' => "RAZORPAY", // COD 
            'currency' => $request->currency,
            'order_note' => $request->order_note,
        ]);
        if($order){
            // 2. Razorpay payment process
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            if(!empty($request->razorpay_payment_id)) {
                try {
                    $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=>$payment['amount']));
                    $order->update(['razorpay_payment_id' => $request->razorpay_payment_id ?? null]);
                
                    // 3. Authenticate with Shiprocket
                    $token = $this->getShiprocketToken();
                    // dd($token);
                    // $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company');
                    // $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup');
                    // dd($response->json());

                        // 4. Create Shiprocket order
                        $shiprocketResponse = Http::withToken($token)->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
                            "order_id" => $order->id,
                            "order_date" => now()->format('Y-m-d'),
                            "pickup_location" => "Pickup Address", 
                            // "pickup_location" => "pickup_address", // Set in Shiprocket dashboard
                            "billing_customer_name" => $request->name,
                            "billing_address" => $request->street,
                            "billing_city" => $request->city,
                            "billing_pincode" => $request->postal_code,
                            "billing_state" => $request->state,
                            "billing_country" => $request->country,
                            "billing_email" => $request->email,
                            "billing_phone" => $request->phone,
                            "order_items" => [
                                [
                                    "name" => $product->name,
                                    "sku" => $product->slug,
                                    "units" => 1,
                                    "selling_price" => $product->price
                                ]
                            ],
                            "payment_method" => "Prepaid",
                            "sub_total" => $request->total,
                            "length" => 10,
                            "breadth" => 10,
                            "height" => 5,
                            "weight" => 0.5
                        ]);
                        // dd($shiprocketResponse);
        
                        // Optional: save tracking/awb
                        if ($shiprocketResponse->successful()) {

                            $tracking = $shiprocketResponse['tracking_data']['track_url'] ?? null;
                            dd("here");
                            $order->update([
                                'status' => 'confirmed',
                                'shiprocket_shipment_id' => $shiprocketResponse['shipment_id'],
                                'awb_code' => $shiprocketResponse['awb_code'] ?? null,
                                'tracking_url' => $tracking,
                                // 'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
                            ]);
                        }
                        // dd("stop");
                    return redirect('/')->with('success', 'Order successfully.');
                } catch (Exception $e) {
                    return  $e->getMessage();
                    // Session::put('error',$e->getMessage());
                    return redirect()->back();
                }
            }
        }
    }
    
    public function orderHistory_single(Request $request)
    {
        $uid = auth()->id();
        $orders = Orders::with(['product','product.firstImage'])->where('user_id',$uid)->latest()->get();
       
        $token = $this->getShiprocketToken();
        foreach ($orders as $order) {

            $order->shipment_id = "123";
            if ($order->shipment_id) {

                $response = Http::withToken($token)->get("https://apiv2.shiprocket.in/v1/external/courier/track/shipment/{$order->shipment_id}");
                if ($response->successful()) {
                    
                    $trackingData = $response->json();
                    $order->tracking = $trackingData[$order->shipment_id]['tracking_data'] ?? null;
                } else {
                    $order->tracking = null;
                }
            } else {
                $order->tracking = null;
            }
        }
        $data['order_history'] = $orders;
        
        return view('web.order.order_history', compact('data'));
    }
    
    public function track()     // verify token valid or not
    {
        $token = $this->getShiprocketToken();
        $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company');
        // $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup');
        // dd($response->json());

        if ($response->status() === 401) {
            // Token expired or invalid
            return 'Shiprocket token expired';
            // Regenerate token here
        } elseif ($response->successful()) {
            dd("here");
            // Token is valid
            return $response->json();
        }
        dd("stop");
        dd($response);
    }
    
    public function track___()     //////  change order status
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
            // dd($data);
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

    public function track__()  // get shiproket data
    {
        $shipment_id = "123";
        $token = $this->getShiprocketToken();
        // dd($token);
        $response = Http::withToken($token)->get("https://apiv2.shiprocket.in/v1/external/courier/track/shipment/$shipment_id");

        $responseData = $response->json();
        $tracking = $responseData[$shipment_id]['tracking_data'];
        // dd($tracking);

        return view('track', ['tracking' => $tracking]);
    }

    // ******************** ******************** ******************** COMMON FUNCTION ******************** //
    private function getShiprocketToken()
    {
        // $shiprocket = app(ShiprocketService::class);
        $shiprocket = new \App\Services\ShiprocketService();
        return $shiprocket->getToken(); // this refreshes and caches

        // if (Cache::has('shiprocket_token')) {
        //     return Cache::get('shiprocket_token');
        // }
        // // Else, get a new token
        // $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
        //     'email' => config('services.shiprocket.email'),
        //     'password' => config('services.shiprocket.password')
        // ]);
        // if (!$response->successful()) {
        //     throw new \Exception('Failed to authenticate with Shiprocket');
        // }
        // $token = $response['token'];

        // // Cache it for 23 hours (less than 24 to be safe)
        // Cache::put('shiprocket_token', $token, now()->addHours(23));

        // return $token;
    }

}