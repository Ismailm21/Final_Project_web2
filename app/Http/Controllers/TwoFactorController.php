<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('OtpView'); // Make sure this view has a form to submit OTP
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp_code' => 'required'
        ]);

        $user = auth()->user();

        if ($user->otp_code === $request->otp_code && now()->lt($user->otp_expires_at)) {
            // Mark user as verified
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->is_verified = true;
            $user->save();

            return redirect()->intended('/dashboard')->with('success', '2FA verified.');
        }

        return back()->withErrors(['otp_code' => 'Invalid or expired code.']);
    }
    public function create()
    {
        //
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}

