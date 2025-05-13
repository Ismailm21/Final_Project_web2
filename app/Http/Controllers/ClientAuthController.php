<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TwoFactor;
use App\Mail\OtpMail;
use App\Models\Client;
use App\Models\Loyalty_point;
use App\Models\LoyaltyPoint;
use App\Models\User;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientAuthController extends Controller
{




    public function showLoginForm()
    {
        return view('login-Client');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            session()->flash('success', 'You have successfully logged in as a client!');

            // Redirect to homepage or another route
            return "Client dashboard";  // put here the client dashboard view(lynn)
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
        }




    // Show signup form
    public function showSignUpForm()
    {
        $loyaltyPoints = LoyaltyPoint::all();  // Get all available loyalty points
        return view('Signup-Client', compact('loyaltyPoints'));
    }

    // Handle signup submission
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',


        ]);


        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->password = Hash::make($validated['password']);
        $user->role = 'client';


        $user->is_verified = false;
        $user->save();
        $user = User::where('email', $validated['email'])->first();
        $user->generateOtpCode();
        session(['user_id' => $user->id]);

        $user->notify(new TwoFactorCode());

        // Create the Client record
        $client = new Client();
        $client->user_id = $user->id;

        $client->save();



        return view('OtpView', ['user_id' => $user->id]);








    }

    public function showOtpForm(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('client.signup')->withErrors(['error' => 'Session expired. Please sign up again.']);
        }

        return view('OtpView', compact('userId'));
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('client.signup')->withErrors(['otp_code' => 'User session expired. Please sign up again.']);
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

            return "welcome to client dashboard";}

        // OTP is incorrect
        return redirect()->route('client.signup')->withErrors(['otp_code' => 'Invalid OTP. Please try again.']);
    }








}

