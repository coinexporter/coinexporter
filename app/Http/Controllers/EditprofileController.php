<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EditprofileController extends Controller
{

    // User data Retrieve .
    public function index()
    {
        $id = Auth::user()->id;
        $userData = User::where('id', $id)->first();
        return view('editprofile', compact('userData'));
    }


    // Update user data .
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'email' => 'required',
            'country' => 'required'
        ]);

        if (!empty($request)) {
            $userData = User::where('id', $id)->first();
            $userData->name = $request->name;
            $userData->email = $request->email;
            $userData->country = $request->country;
            if ($userData->save()) {
                return redirect()->back()->with('success', 'Profile saved Successfully!');
            } else {
                return redirect()->back()->with('error', 'Profile Not Saved!');
            }
        }
    }

    // Update user profile image
    public function imagestore(Request $request)
    {

        $id = Auth::user()->id;
        $filename = '';
        if ($request->file('profileImage')) {
            $file = $request->file('profileImage');
            $filename = $id . "-" . $file->getClientOriginalName();

            $file->move(public_path('images'), $filename);
            if ($request->oldProfile != '' || $request->oldProfile != null) {
                if (file_exists(public_path('images/' . $request->oldProfile))) {
                    unlink(public_path('images/' . $request->oldProfile));
                }
            }
            $userData = User::where('id', $id)->first();
            $userData->profileImage = $filename;
            if ($userData->save()) {
                return redirect()->back()->with('success', 'Profile Image saved Successfully!');
            } else {
                return redirect()->back()->with('error', 'Profile Image Not Saved!');
            }
        }
    }



    // Change user password
    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'min:8|required',
            'ConfirmPassword' => 'min:8|required'

        ]); // create the validations
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {
           
            // $request->session()->flash($validator->errors(),422);
            // return redirect()->back();
             $errors = $validator->errors();
             return redirect()->back()->with('error',$errors);
           // return response()->json($validator->errors(),422);  
            // validation failed return back to form

        } else {
        $id = Auth::user()->id;
        $userData = User::where('id', $id)->first();
        
      
        if (Hash::check($request->oldPassword, $userData->password)) {
            if ($request->newPassword == $request->ConfirmPassword) {
                $userData->password = Hash::make($request->newPassword);
                if ($userData->save()) {
                    //$request->session()->flash('success', 'You are Logged In Successfully!');
                    //return response()->json(["status"=>true,"redirect_location"=>url("/editprofile")]);
                    return redirect()->back()->with('success', 'Password Updated Successfully!');
                    } else {
                        //return response()->json([["Password Not Updated!"]],422);
                        return redirect()->route('/editprofile')->with('error', 'Unsuccess!');
                     }
                } else {
                    //return response()->json([["Confirm password does not match."]],422);
                    return redirect()->back()->with('error', 'Confirm password does not match.');
                }
            } else {
                //return response()->json([["Old Password Does not match."]],422);
                return redirect()->back()->with('error', 'Old Password Does not match.');
            } 
     
    } 
}
}
