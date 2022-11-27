<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('verify-email');
    }
    public function __invoke(EmailVerificationRequest $request)
    {
                if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if( $_SERVER['REMOTE_ADDR'] == Auth::user()->ip_address){
             if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            }

        return redirect()->intended(RouteServiceProvider::DASHBOARD.'?verified=1')->with('success', 'Congratulations! Your IP address is confirmed. Thanks!');
        }else{
            //echo "123";exit;
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=0')->with('error', 'Could not verify your account because your IP Address not matched!');
        }
    }
}
