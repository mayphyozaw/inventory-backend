<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Role::class;
    }

    public function find($id)
    {
        $record = $this->model::find($id);
        return $record;
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }


    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
    }

    public function roleDatatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->addIndexColumn() 
            ->addColumn('permissions', function ($each) {
                $output = " ";
                foreach ($each->permissions as $permission ) {
                    $output .= '<span class="badge rounded-pill text-bg-primary" style="margin-right:5px;"> '.$permission->name.' </span>';
                }
                return $output;
            })
            ->addColumn('action', function ($role) {
                return view('admin.backend.role._action', compact('role'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['permissions','action'])
            ->make(true);
    }
}
