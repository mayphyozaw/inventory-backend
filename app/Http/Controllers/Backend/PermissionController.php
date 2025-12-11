<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionStoreRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Repositories\PermissionRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $roleRpermissionRepositoryepository;

     public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        if(!auth()->user()->hasPermissionTo('all_permission')){
            abort(403, 'Unauthorized Action');
        }
        
        $permissions = Permission::all();
        return view('admin.backend.permission.index',compact('permissions'));
    }

    public function create()
    {
        return view('admin.backend.permission.create');
    }

    public function store(PermissionStoreRequest $request)
    {
        

        try {
            $this->permissionRepository->create([
                'name'  => $request->name,
                'group_name'  => $request->group_name,
                
            ]);

            return redirect()->route('permission.index')->with([
                'message' => 'Permission created successfully!',
                'alert-type' => 'success'
            ]);
            // return Redirect::route('permission.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function permissionDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->permissionRepository->permissionDatatable($request);
        }
    }

    public function edit($id)
    {
        if(!auth()->user()->hasPermissionTo('edit_permission')){
            abort(403, 'Unauthorized Action');
        }
        
        $permission = Permission::findOrFail($id);
        return view('admin.backend.permission.edit', compact('permission')); 
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
       

        try {
            $this->permissionRepository->update($id, [
                'name'  => $request->name,
                'group_name'  => $request->group_name,
            ]);
            
            return redirect()->route('permission.index')->with([
                'message' => 'Permission updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
           
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('delete_permission')){
            abort(403, 'Unauthorized Action');
        }
        
        try {
            $this->permissionRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
