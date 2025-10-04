<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminUserRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = User::class;
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


    public function update($id,array $data)
    {
        $record = $this->model::find($id);
        $record -> update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
    }

    public function datatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
        ->addIndexColumn()
        ->editColumn('photo', function($user){
            return '<img src="{{ $user->acsr_image_path }}" alt="Profile" width="100">';
            // return '<img src="'. $user->acsrImagePath . '" 
            //  alt="User Photo" 
            //  style="width:20px; height:20px; border:1px solid gray; border-radius:2px; padding:2px">';
        })
        ->addColumn('action', function($user){
            return view('admin.admin-profile._action', compact('user'));
        })
        ->addColumn('responsive-icon', function ($data) {
                return null;
        })
        ->rawColumns(['photo'])
        ->make(true);
    }
}