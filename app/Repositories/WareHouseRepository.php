<?php

namespace App\Repositories;

use App\Models\WareHouse;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WareHouseRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = WareHouse::class;
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

    public function warehouseDatatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->addIndexColumn() 
            
            ->addColumn('action', function ($warehouse) {
                return view('admin.backend.warehouse._action', compact('warehouse'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
