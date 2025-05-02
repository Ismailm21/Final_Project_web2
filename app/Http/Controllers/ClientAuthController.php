<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Client;
use App\Models\Loyalty_point;
use App\Models\User;
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
            // Flash a success message
            session()->flash('success', 'You have successfully logged in as a client!');

            // Redirect to homepage or another route
            return "Client signedin";  // Change 'home' to your desired route
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
        }




    // Show signup form
    public function showSignUpForm()
    {
        $loyaltyPoints = Loyalty_point::all();  // Get all available loyalty points
        return view('Signup-Client', compact('loyaltyPoints'));
    }

    // Handle signup submission
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'loyalty_points_id' => 'nullable|exists:loyalty_points,id',
            'Achievements' => 'required|in:Bronze,Silver,Gold,Platinum',

        ]);





        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $otp = rand(100000, 999999);
        $user->password = Hash::make($validated['password']);
        $user->role = 'client';
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5); // expires in 5 minutes
        $user->is_verified = false;
        $user->save();

        // Create the Client record
        $client = new Client();
        $client->user_id = $user->id;  // Associate with the created user
        $client->loyalty_points_id = $validated['loyalty_points_id'] ?? null;
        $client->Achievements = $validated['Achievements'];
        $client->save();


        session(['otp_code' => $otp, 'user_id' => $client->id]);
        Mail::to($client->email)->send(new OtpMail($otp));

        // Flash a success message
        session()->flash('success', 'You have successfully signed up as a client!');
        // Log the user in
        auth()->login($user);

        // TODO: Send OTP via SMS or Email — here, we just simulate it
        logger("OTP for user {$user->email} is {$otp}");

        // Redirect to OTP verification view
        return redirect()->route('otp.verify.form')->with('user_id', $user->id);


        // Redirect to homepage or another route

    }

    public function showOtpForm(Request $request)
    {
        $userId = session('user_id'); // retrieved from signup redirect
        return view('OtpView', compact('userId'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp_code' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        if (
            $user &&
            $user->otp_code === $request->otp_code &&
            now()->lessThanOrEqualTo($user->otp_expires_at)
        ) {
            $user->is_verified = true;
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            auth()->login($user);
            session()->flash('success', 'OTP verified successfully!');

            return redirect()->route('WelcomePage');
        }

        return back()->withErrors(['otp_code' => 'Invalid or expired OTP.']);
    }
}
