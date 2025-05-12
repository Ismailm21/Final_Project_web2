<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'role' => 'client', // or 'driver' based on context
                    'is_verified' => true,
                    'password' => bcrypt(uniqid()), // Dummy password
                ]);
            }

            Auth::login($user);

            // Redirect based on role
            return $user->role === 'driver'
                ? redirect()->route('driver.dashboard')
                : redirect()->route('client.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Authentication failed.']);
        }
    }
}
