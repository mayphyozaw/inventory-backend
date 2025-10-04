<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.change-password',[
            'user' => $request->user(),
        ]);
    }


    public function update(ChangePasswordRequest $request)
    {
        try {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', "Successfully changed");
    
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        } 
            
    
    }

    //  public function adminPasswordUpdate(Request $request)
    // {
        
    //     $user = Auth::user();

    //     $validator = Validator::make($request->all(), [
    //         'old_password' => 'required',
    //         'password' => 'required|min:6|confirmed',
    //     ]);

    //      if ($validator->fails()) {
    //         $notification = [
    //             'message' => $validator->errors()->first(), 
    //             'alert-type' => 'error',
    //         ];
    //         return back()->with($notification)->withErrors($validator)->withInput();
    //     }


    //     if(!Hash::check($request->old_password, $user->password)){
    //         $notification = array(
    //             'message' => 'Old Password Does not Match!',
    //             'alert-type' => 'error',
    //         );
    //         return back()->with($notification);
    //     }

    //     User::whereId($user->id)->update([
    //         'password' => Hash::make($request->password),
    //     ]);

    //     Auth::logout();

    //     $notification = array(
    //             'message' => 'Password updated successfully!',
    //             'alert-type' => 'success',
    //         );
    //         return redirect()->route('login')->with($notification);
    // }
}
