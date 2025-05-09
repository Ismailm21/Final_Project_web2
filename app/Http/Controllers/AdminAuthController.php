<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Login-Admin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin'
        ])) {
            return redirect()->route('admin.dashboard');
        }


        return back()->withErrors(['email' => 'Invalid credentials or not an admin.']);
    }

    // ✅ REMOVE public signup route and form
    // public function showSignUpForm()
    // {
    //     return view('Signup-Admin');
    // }

    // ✅ Moved to admin dashboard only
    public function storeDriver(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'driver',
            'authentication_method' => 'username',
            'provider_id' => 'manual',
        ]);

        return redirect()->route('admin.driver')->with('success', 'Driver created successfully.');
    }
}
