<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleRepository;

     public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $role = Role::all();
        return view('admin.backend.role.index',compact('role'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.backend.role.create',compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {

        try {
            $role = $this->roleRepository->create([
                'name'  => $request->name,
                
            ]);
            $role->givePermissionTo($request->permissions);
            
            return Redirect::route('role.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function roleDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->roleRepository->roleDatatable($request);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $old_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('admin.backend.role.edit', compact('role','old_permissions','permissions')); 
    }

    public function update(RoleUpdateRequest $request, $id)
    {
       

        try {
            $role = $this->roleRepository->update($id, [
                'name'  => $request->name,
                
            ]);
            $old_permissions = $role->permissions->pluck('name')->toArray();
            $role->revokePermissionTo($old_permissions);

            $role->givePermissionTo($request->permissions);
            return redirect()->route('role.index')->with([
                'message' => 'Roles updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
           
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $this->roleRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }


    // Role in Permission All Methods 
    public function addRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        // $permission_groups = User::getpermissionGroups();
        $permission_groups = Permission::all()->groupBy('group_name');
        // $permissions_group_names = User::getermissionGroupByName(Permission::$group->group_name);
        return view('admin.backend.rolesetup.add_roles_permission', compact('roles','permissions','permission_groups'));
    }

    public function rolePermissionStore(Request $request)
    {
        $data = array();
        $permissions = $request->permission;
        
        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;
        }
       
        DB::table('role_has_permissions')->insert($data);

        return redirect()->route('role.index')->with([
                'message' => 'Role Permission updated successfully!',
                'alert-type' => 'success'
            ]);
    }
}
