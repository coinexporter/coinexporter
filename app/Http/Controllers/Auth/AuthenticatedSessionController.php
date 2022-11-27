<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        //dd($request->all());
    //     $request->authenticate();

    //     $request->session()->regenerate();
    //     if($request->session()->regenerate() == 'true'){
    //    // return redirect()->intended(RouteServiceProvider::HOME)->with('success','You are Logged In Successfully!');
    //     return response()->json(["status"=>true,"success"=>"You are Logged In Successfully!","redirect_location"=>url("/")]);  
    //     }else{
    //         return redirect()->intended(RouteServiceProvider::HOME)->with('error','Oops! Something went wrong, your login Failed!');   
    //     }     

        if (Auth::guard('web')->attempt($request->only(["email", "password"], ($request->remember == 'on') ? true : false))) {
            $request->session()->flash('success', 'You are Logged In Successfully!');
            return response()->json(["status"=>true,"redirect_location"=>url("/jobspace")]);
            
        } else {
            return response()->json([["Invalid credentials"]],422);
            
        }
        
    }

  public function userstore(LoginRequest $request)
    {
        //dd($request->all());
    //     $request->authenticate();

    //     $request->session()->regenerate();
    //     if($request->session()->regenerate() == 'true'){
    //    // return redirect()->intended(RouteServiceProvider::HOME)->with('success','You are Logged In Successfully!');
    //     return response()->json(["status"=>true,"success"=>"You are Logged In Successfully!","redirect_location"=>url("/")]);  
    //     }else{
    //         return redirect()->intended(RouteServiceProvider::HOME)->with('error','Oops! Something went wrong, your login Failed!');   
    //     }     

        if (Auth::guard('web')->attempt($request->only(["email", "password"], ($request->remember == 'on') ? true : false))) {
             
            return redirect(RouteServiceProvider::DASHBOARD)->with('success','You are Logged In Successfully!');
        } else {
            redirect()->back()->with('error', 'Something went wrong!'); 
        }
            
        
        
    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        if($request->session()->regenerate() == 'true'){
        return redirect('/')->with('success','You are Logged Out Successfully!');
    }else{
        return redirect('/')->with('error','Oops! Something went wrong, Please try again!');   
    }    
    }
}
