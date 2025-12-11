<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\AdminUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    protected $adminUserRespository;

    public function __construct(AdminUserRepository $adminUserRespository)
    {
        $this->adminUserRespository = $adminUserRespository;
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // public function adminLogin(Request $request)
    // {

    //    if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
    //    {

    //         return redirect()->intended('/dashboard');
    //     }
    //     return redirect()->back()->withErrors(['email'=>'Invaild Credential Provided']);

    // }

    public function index()
    {
        $currentUser = Auth::user();
        $profileData = User::all();
        return view('admin.admin-profile.index', compact('currentUser', 'profileData'));
    }


    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminUserRespository->datatable($request);
        }
    }

    public function create()
    {

        return view('admin.admin-profile.create');
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
        $currentUser = Auth::user();
        $profileData = User::findOrFail($id);

        return view('admin.admin-profile.edit', compact('currentUser', 'profileData'));
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // Update basic fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle profile image
        if ($request->hasFile('photo')) {
            // Delete old image if exists
            if ($user->photo && file_exists(public_path('upload/user_images/' . $user->photo))) {
                unlink(public_path('upload/user_images/' . $user->photo));
            }

            $file = $request->file('photo');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images/'), $filename);

            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('admin-profile.index')->with([
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);

        if ($item->photo && file_exists(public_path('upload/user_images/' . $item->photo))) {
            unlink(public_path('upload/user_images/' . $item->photo));
        }

        $item->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }


    public function adminPasswordUpdate(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $notification = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return back()->with($notification)->withErrors($validator)->withInput();
        }


        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }

        User::whereId($user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::logout();

        $notification = array(
            'message' => 'Password updated successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('login')->with($notification);
    }


    public function admin_profile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function profile_store(Request $request)
    {
        $data = User::findOrFail(auth()->id());
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->password) {
            $data->password = Hash::make($request->password);
        }

        
        $oldPhotoPath = $data->photo;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Storage::put('upload/' . $filename, file_get_contents($file));
            $file->move(public_path('upload/user_images/'), $filename);
            
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        
        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert_type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function password_update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' =>  'Old Password does not match!',
                'alert_type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereID($user->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        Auth::logout();

        $notification = array(
            'message' =>  'Password Updated Successfully!',
            'alert_type' => 'success '
        );
        return redirect()->route('login')->with($notification);
    }
}
