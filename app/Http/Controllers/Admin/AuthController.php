<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DB;

class AuthController extends Controller
{
    public function index()
    {
        // dd(Hash::make('123456'));
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $data = Admin::where('email', $request->email)->first();
        if (!is_null($data)) {

            if (!Hash::check($request->password, $data->password)) {
                return redirect('admin/login')->with('error', 'Oppes! You have entered Incorrect password.');
            }
            session([
                'admin_id' => $data->id,
                'admin_name' => $data->name,
            ]);
            if (!$data->google2fa_secret || is_null($data->google2fa_secret)) {
                return redirect()->route('2fa.form');
            }           
            // Insert login log
            DB::table('admin_logs')->insert([
                'login_ip' => $request->ip(),
                'type' => 'login',
                'created_at' => now(),
            ]);
            return redirect()->intended('admin/dashboard')->withSuccess('You have Successfully loggedin');
        }
        return redirect('admin/login')->with('error', 'Oppes! You have entered invalid credentials.');
    }

    public function dashboard(Request $request)
    {
        if (Session::has('admin_name') && !empty(session('admin_name'))) {
            $today = date('Y-m-d');
            $data['products'] = DB::table('products')->count();
            $data['orders'] = DB::table('orders')->count();

            return view('admin.dashboard',['data' => $data]);
        }
        return redirect('admin/login')->with('error', 'Opps! You do not have access.');
    }

    public function account_setting(Request $request)
    {
        $data = Admin::where('id', session('admin_id'))->first();
        return view('admin.auth.account_setting', compact('data'));
    }

    public function account_setting_change(Request $request)
    {
        $data = Admin::where('id',$request->id)->first();
        if (!is_null($data)) {

            if (!Hash::check($request->old_password, $data->password)) {
                return redirect('admin/account_setting')->with('error', 'The previous password entered does not match the current one.');
            }
            $data->update(['password' => Hash::make($request->password)]);

            return redirect('admin/login')->with('success', 'The password has been changed successfully.');
        }
        return redirect('admin/dashboard')->with('error','Opps! Somthing wents wrong');
    }

    public function logout() {
        Session::flush();
        return Redirect('admin/login');
    }

}
