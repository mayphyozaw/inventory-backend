<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AdminUserController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $profileData = User::all();
        return view('admin.admin-user.index', compact('currentUser', 'profileData'));
    }

    public function create()
    {
        return view('admin.admin-user.create');
    }

    public function store(UserStoreRequest $request)
    {
            
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->password = Hash::make($request->password);

        $profile_img_name = null;
        if ($request->hasFile('photo')) {
            $profile_img_file = $request->file('photo');
            $profile_img_name = uniqid() . '_' . time() . '.' . $profile_img_file->getClientOriginalExtension();
            $profile_img_file->move(public_path('upload/user_images'), $profile_img_name);
        }

        $data->photo = $profile_img_name;

        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function edit($id)
    {

        $profileData = User::findOrFail($id);
        return view('admin.admin-user.edit', compact('profileData'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('photo')) {
            $profile_img_file = $request->file('photo');
            $profile_img_name = uniqid() . '_' . time() . '.' . $profile_img_file->getClientOriginalExtension();
            $profile_img_file->move(public_path('upload/user_images'), $profile_img_name);
        }

        $user->photo = $profile_img_name ?? $user->photo;
        $user->update();

        return redirect()->route('admin-user.index')->with([
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);

        if ($item->photo && file_exists(public_path('upload/user_images/' . $item->photo))) {
            Storage::delete(public_path('upload/user_images/' . $item->photo));
        }

        $item->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
