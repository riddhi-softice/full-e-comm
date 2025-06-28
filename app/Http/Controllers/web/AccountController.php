<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function dashboard()  
    {
        $uid = auth()->id();
        $data['user_details'] = User::with('address')->where('id',$uid)->first();
        $data['order_count'] = Orders::where('user_id',$uid)->count();

        return view('web.dashboard', compact('data'));
    }
    
    public function update_account(Request $request)  
    {
        $uid = auth()->id();
        // dd($request->all());     
        $data = User::where('id',$uid)->first();
        if (!is_null($data)) {

            if (!Hash::check($request->old_password, $data->password)) {
                return redirect('/account_setting')->with('error', 'The previous password entered does not match the current one.');
            }
            $input = [
                // 'name' => $request->f_name . " " . $request->l_name,
                'name' => $request->name,
                'password' => Hash::make($request->new_password)
            ];
            $data->update($input);
        }
        return redirect('user/dashboard')->with('error','Opps! Somthing wents wrong');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->back()->with('success', 'Logged out successfully.');
    }

}