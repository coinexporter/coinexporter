<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SocialPlatform;
use App\Models\SocialLink;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ReffereduserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $referralCode = User::where('id', $id)->first()->referral_code;
        $refferedUsers = User::where('referrer_code',$referralCode)->paginate(10);
       // $country = Country::where('id', $userData->country)->first();

        return view('refferedusers', compact('refferedUsers'));
    }

    
}
