<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleHasPermissionController extends Controller
{
    public function allRolesPermission()
    {
        $roles = Role::all();
        return view('admin.backend.rolesetup.all_role_permission', compact('roles'));
    }

    // Role in Permission All Methods 
    public function addRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = Permission::all()->groupBy('group_name');
        return view('admin.backend.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    public function rolePermissionStore(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
            'permission' => 'nullable|array',
        ]);

        try {
            $data = [];
            $permissions = $request->permission;
            if ($permissions) {
                foreach ($permissions as $key => $item) {
                    $data[] = [
                        'role_id' => $request->role_id,
                        'permission_id' => $item,
                    ];
                }
                DB::table('role_has_permissions')->insert($data);
            }

            return redirect()->route('all.roles.permission')->with([
                'message' => 'Roles updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function adminEditRoles($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = Permission::all()->groupBy('group_name');
        return view('admin.backend.rolesetup.edit_roles_permission', compact('role', 'permissions', 'permission_groups'));
    }

    public function adminUpdateRoles(Request $request, $id)
    {

        try {

            $role = Role::findOrFail($id);

            $role->update([
                'name'  => $request->name,

            ]);

            // $permissions = $request->permission ?? [];
            $permissions = Permission::whereIn('id', $request->permission ?? [])->get();

            $role->syncPermissions($permissions);

            return redirect()->route('all.roles.permission')->with([
                'message' => 'Roles updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function rolePermissionDatatable(Request $request)
    {
        $role = Role::query();

        return DataTables::eloquent($role)
            ->addIndexColumn()

            ->addColumn('permissions', function ($role) {
                $output = " ";
                foreach ($role->permissions as $permission) {
                    $output .= '<span class="badge rounded-pill text-bg-primary" style="margin-right:5px;"> ' . $permission->name . ' </span>';
                }
                return $output;
            })

            ->addColumn('actions', function ($role) {
                return view('admin.backend.rolesetup._action', compact('role'))->render();
            })
            ->rawColumns(['permissions', 'actions'])
            ->make(true);
    }

    public function adminDeleteRole($id)
    {

        try {

            $role = Role::findOrFail($id);

            if (!is_null($role)) {
                $role->delete();
            }
            // return redirect()->back()->with('success', 'Role deleted successfully!');
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }


    public function allAdmin()
    {
        $allAdmin = User::where('role', 'admin')->latest()->get();
        return view('admin.backend.admin-manage.all_admin', compact('allAdmin'));
    }



    public function allAdminDatatable(Request $request)
    {
        $allAdmin = User::query();

        return DataTables::eloquent($allAdmin)
            ->addIndexColumn()

            ->addColumn('roles', function ($allAdmin) {

                foreach ($allAdmin->roles as $role) {
                    return '<span class="badge badge-pill text-bg-danger" style="margin-right:5px;"> ' . ($role->name ?? '') . ' </span>';
                }
            })

            ->addColumn('actions', function ($allAdmin) {
                return view('admin.backend.admin-manage._action', compact('allAdmin'))->render();
            })
            ->rawColumns(['roles', 'actions'])
            ->make(true);
    }


    public function addAdmin()
    {
        $roles = Role::all();
        return view('admin.backend.admin-manage.add_admin', compact('roles'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->save();

        if ($request->roles) {
            $role = Role::where('id', $request->roles)->where('guard_name', 'web')->first();
            if ($role) {
                $user->assignRole($role);
            }
        }


        return redirect()->route('all.admin')->with([
            'message' => 'New Admin inserted successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function editAdmin($id)
    {
        $admin = User::find($id);
        //  $role = Role::all();
        $roles = Role::where('guard_name', 'web')->get();
        return view('admin.backend.admin-manage.edit_admin', compact('admin', 'roles'));
    }

    public function updateAdmin(Request $request, $id)
    {

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'admin';
        $user->save();

        $user->roles()->detach();


        if ($request->roles) {
            $role = Role::where('id', $request->roles)->where('guard_name', 'web')->first();
            if ($role) {
                $user->assignRole($role);
            }
        }

        return redirect()->route('all.admin')->with([
            'message' => 'New Admin updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function deleteAdmin($id)
    {
        // $admin = User::find($id);
        // if (!is_null($admin)) {
        //     $admin->delete();
        // }
        // return redirect()->route('all.admin')->with([
        //     'message' => 'Admin deleted successfully!',
        //     'alert-type' => 'success'
        // ]);
        //     // return ResponseService::success([], 'Successfully deleted');

        try {
            $admin = User::findOrFail($id);
            if (!is_null($admin)) {
                $admin->delete();
            }
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
