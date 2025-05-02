<?php

namespace App\Http\Controllers;


use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Login-Driver');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'driver'], $request->remember)) {
            return redirect()->route('driver.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials or you are not a driver.']);
    }

    // Show the Driver sign-up form
    public function showSignUpForm()
    {
        return view('Signup-Driver');
    }

    // Handle the Driver sign-up process
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'vehicle_number' => 'required|string|unique:drivers,vehicle_number',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user in the 'users' table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'driver',
        ]);

        // Create the driver in the 'drivers' table, linked to the user
        $driver = new Driver();
        $driver->user_id = $user->id;
        $driver->vehicle_type = $request->vehicle_type ?? 'motorcycle';  // Default to motorcycle
        $driver->vehicle_number = $request->vehicle_number;
        $driver->save();

        // Log in the driver automatically after sign-up
        Auth::login($user);

        // Redirect to the driver dashboard or other relevant page
        return redirect()->route('driver.dashboard');
    }

    public function storeDriver(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'driver',
            'authentication_method' => 'username',
        ]);

        return redirect()->route('admin.driver')->with('success', 'Driver added successfully.');
    }

}
