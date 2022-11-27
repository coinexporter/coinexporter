<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Notification;
use Cookie;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
       // echo $request->get('link') ;exit;
       $userData = User::where('referral_link', $request->link)->first();
      
        return view('auth.register',compact('userData'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request,User $user)
    {
        //dd($request->all());
       

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',   // required and email format validation
             // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //'password' => 'required|min:8', 
            
            // required and number field validation
           // 'confirm_password' => 'confirmed|min:8',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'country'=> 'required',
            'terms'=> 'required',

        ]); // create the validations
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {
            return response()->json($validator->errors(),422);  
            // validation failed return back to form

        } else {
        if(!empty($request->referrer_code)){
            $ref_code = $request->referrer_code;
            }else{
                $ref_code ='NULL';
            } 
            $randomNumber = random_int(100000, 999999);
            $refferal_code = 'CE'.$randomNumber;
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $referrer_id = md5(uniqid(rand(), true));
            $baseurl = BASEURL;
            $referral_link = $baseurl.'Ref='.$referrer_id;
            //$referred_by = Cookie::get('referral');
            //$referrer = User::whereemail(session()->pull('referrer'))->first();
            //dd($referrer);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'referral_code' =>$refferal_code,
            'referrer_code' => $ref_code,
            'terms' => $request->terms,
            'ip_address' => $ip_address,
            'referral_link' => $referral_link,
            'status' => 'active' 
        ]);
       
        event(new Registered($user));
        
      // Auth::login($user);

        //return redirect(RouteServiceProvider::HOME)->with('success','You are Registered Successfully!');
        if($user){
        	
            Auth::login($user);
            $request->session()->flash('success', 'You are Registered Successfully!');
            return response()->json(["status"=>true,"redirect_location"=>url("/jobspace")]);
            
            //return redirect(RouteServiceProvider::DASHBOARD)->with('success','You are Registered Successfully!');
        } else {
            return response()->json(["Something Wrong!"],422);
            //return response()->json($validator->errors(),422); 
        }
      }
    }
    // public function checkDuplicateEmail(Request $request){
    //     if($request->ajax()){
    //         $adminEmail = $request->email;
    //         $emailCount = Users::where('email', $adminEmail)->count();
    //         if($emailCount>0){
    //             echo "false";
    //         } else {
    //             echo "true";
    //         }
    //     }
    // }
    public function refstore(Request $request,User $user)
    {
        //dd($request->all());
       

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',   // required and email format validation
             // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //'password' => 'required|min:8', 
            
            // required and number field validation
           // 'confirm_password' => 'confirmed|min:8',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'country'=> 'required',
            'terms'=> 'required',

        ]); // create the validations
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {
           // return response()->json($validator->errors(),422);  
           return redirect()->back()->withErrors( $validator->errors()); 
            // validation failed return back to form

        } else {
        if(!empty($request->referrer_code)){
            $ref_code = $request->referrer_code;
            }else{
                $ref_code ='NULL';
            } 
            $randomNumber = random_int(100000, 999999);
            $refferal_code = 'CE'.$randomNumber;
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $referrer_id = md5(uniqid(rand(), true));
            $baseurl = BASEURL;
            $referral_link = $baseurl.'Ref='.$referrer_id;
            //$referred_by = Cookie::get('referral');
            //$referrer = User::whereemail(session()->pull('referrer'))->first();
            //dd($referrer);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            //'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'referral_code' =>$refferal_code,
            'referrer_code' => $ref_code,
            'terms' => $request->terms,
            'ip_address' => $ip_address,
            'referral_link' => $referral_link,
            'status' => 'active'
        ]);
       
        event(new Registered($user));
        
       

        //return redirect(RouteServiceProvider::HOME)->with('success','You are Registered Successfully!');
        if($user){
            Auth::login($user);
            return redirect(RouteServiceProvider::DASHBOARD)->with('success','You are Registered Successfully!');
        } else {
            redirect()->back()->with('error', 'Something went wrong!'); 
        }
      }
    }
    protected function registered(Request $request, $user)
    {
        if ($user->referrer !== null) {
            Notification::send($user->referrer, new ReferrerBonus($user));
        }
    
        return redirect($this->redirectPath());
    }
    
}
