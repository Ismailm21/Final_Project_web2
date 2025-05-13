<?php

namespace App\Http\Controllers;


use App\Models\Driver;
use App\Models\User;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Area;

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
        $area =new Area();
        $area->name="burj Hammoud";
        $area->longtitude=35.0;
        $area->latitude=32.0;
        $area->save();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'vehicle_number' => 'required|string|unique:drivers,vehicle_number',
            'vehicle_type' => 'required|string',
            'pricing_model' => 'required|in:fixed,perKilometer',
            'password' => 'required|string|min:6|confirmed',

        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'driver',
            'is_verified' => false,
        ]);

        //$areaId = Area::firstOrCreate(['name' => $request->area])->id;

        // Create Driver
        $driver = new Driver();
        $driver->user_id = $user->id;
        $driver->area_id = $area->id;
        $driver->license = "LB License";
        $driver->vehicle_type = $request->vehicle_type;
        $driver->vehicle_number = $request->vehicle_number;
        $driver->pricing_model = $request->pricing_model;
        $driver->save();

        // Generate OTP & Notify
        session(['user_id' => $user->id]); // Save user ID in session
        $user->generateOtpCode();          // Generate OTP
        $user->notify(new TwoFactorCode()); // Send OTP via email

        return redirect()->route('driver.verify.otp');




    }

    public function storeDriver(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'pricing_model' => 'required|in:fixed,perKilometer',

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

    public function showDriverOtpForm(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('driver.signup')->withErrors(['error' => 'Session expired. Please sign up again.']);
        }

        return view('OtpViewDriver', compact('userId'));  // Use 'OtpView' for the driver OTP form
    }

    public function verifyDriverOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('driver.signup')->withErrors(['otp_code' => 'User session expired. Please sign up again.']);
        }

        if (!$user->otp_code || now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'OTP has expired. Please request a new one.']);
        }

        if ($user->otp_code == $request->otp_code) {
            $user->resetOtpCode();
            $user->is_verified = true;
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            auth()->login($user);

            return redirect()->route('driver.dashboard'); // Redirect to driver dashboard
        }

        // OTP is incorrect
        return redirect()->route('driver.signup')->withErrors(['otp_code' => 'Invalid OTP. Please try again.']);
    }


}

