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
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        if(!auth()->user()->hasPermissionTo('all_roles')){
            abort(403, 'Unauthorized Action');
        }
        
        $role = Role::all();
        return view('admin.backend.role.index', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.backend.role.create', compact('permissions'));
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
        if(!auth()->user()->hasPermissionTo('edit_role')){
            abort(403, 'Unauthorized Action');
        }
        
        $role = Role::findOrFail($id);
        $old_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('admin.backend.role.edit', compact('role', 'old_permissions', 'permissions'));
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
        if(!auth()->user()->hasPermissionTo('delete_role')){
            abort(403, 'Unauthorized Action');
        }
        
        try {
            $this->roleRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }


    // public function adminUpdateRolesPermssions(Request $request, $id)
    // {
    //     try {
    //         $role = Role::findOrFail($id);
    //         $permission_groups = Permission::all()->groupBy('group_name');

    //         $old_permissions_ids = $role->permissions->pluck('id')->toArray();

    //         return view(
    //             'admin.backend.rolesetup.edit_roles_permission',
    //             compact('role', 'permission_groups', 'old_permissions_ids')
    //         );
    //     } catch (Exception $e) {
    //         return back()->with('error', $e->getMessage())->withInput();
    //     }
    // }

    
}
