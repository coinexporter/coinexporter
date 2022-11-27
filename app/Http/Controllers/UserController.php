<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    
    public function guard() 
    {
        return Auth::guard('web');
    }

public function logview($id)
	{
       
		$userpromotors = User::find($id);
       
        Auth::login($userpromotors);
        return redirect()->route('user.dashboard')->with('success', 'Logged In Successfully!');
       
    }
}