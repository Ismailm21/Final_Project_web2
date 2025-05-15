<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;


class SocialiteController extends Controller
{


    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account', 'access_type' => 'offline'])
            ->redirect();
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('social_id', $user->getId())->first();

            if ($finduser) {
                Auth::login($finduser);
                return "Welcome back, client ID: " . $finduser->id;
            } else {
                $newuser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => 'client',
                    'social_id' => $user->getId(),
                    'social_type' => 'google',
                    'is_verified' => true,
                    'password' => Hash::make('my-google'), // Dummy password
                ]);

                Auth::login($newuser);
                return "Welcome, new client ID: " . $newuser->id;
            }
        } catch (\Exception $e) {
            return redirect()->route('client.login')->withErrors(['msg' => 'Google authentication failed.']);
        }
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();

            $finduser = User::where('social_id', $user->getId())->first();

            if ($finduser) {
                Auth::login($finduser);
                return "Welcome back, client ID: " . $finduser->id;
            } else {
                $newuser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => 'client',
                    'social_id' => $user->getId(),
                    'social_type' => 'facebook',
                    'is_verified' => true,
                    'password' => Hash::make('my-facebook'), // Dummy password
                ]);

                Auth::login($newuser);
                return "Welcome, new client ID: " . $newuser->id;
            }
        } catch (\Exception $e) {
            return redirect()->route('client.login')->withErrors(['msg' => 'Facebook authentication failed.']);
        }
    }

    public function handleGitHubCallback()
    {
        try {
            $user = Socialite::driver('github')->stateless()->user();

            $finduser = User::where('social_id', $user->getId())->first();

            if ($finduser) {
                Auth::login($finduser);
                return "Welcome back, client ID: " . $finduser->id;
            } else {
                $newuser = User::create([
                    'name' => $user->name ?? $user->nickname, // Fallback to nickname if no name
                    'email' => $user->email,
                    'role' => 'client',
                    'social_id' => $user->getId(),
                    'social_type' => 'github',
                    'is_verified' => true,
                    'password' => Hash::make('my-github'), // Dummy password
                ]);

                Auth::login($newuser);
                return "Welcome, new client ID: " . $newuser->id;
            }
        } catch (\Exception $e) {
            return redirect()->route('client.login')->withErrors(['msg' => 'GitHub authentication failed.']);
        }
    }


}
