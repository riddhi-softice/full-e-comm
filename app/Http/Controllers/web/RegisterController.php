<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
         $request->validate([
           'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // session(['user_id' => $user->id]);
        Auth::login($user);  // Set authenticated session

        return redirect('user/dashboard')->with('success', 'Registration successfully.');
        // return redirect()->back()->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('login-error', 'Email not registered.')->withInput();
        }
            
        
        // $credentials = $request->only('email', 'password');
        // $remember = $request->has('remember');

        // dd([
        //     'credentials' => $request->only('email', 'password'),
        //     'user_exists' => User::where('email', $request->email)->exists(),
        //     'stored_password' => optional(User::where('email', $request->email)->first())->password,
        //     'login_result' => Auth::attempt($request->only('email', 'password'))
        // ]);

         // Check password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('login-error', 'Incorrect password.')->withInput();
        }

        // Successful login
        return redirect('user/dashboard')->with('success', 'Login successfully.');
        // return redirect()->back()->with('success', 'Login successful!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back()->with('success', 'Logged out successfully.');
    }

}