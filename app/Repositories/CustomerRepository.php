<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Customer::class;
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

    public function customerDatatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->addIndexColumn() 
            
            ->addColumn('action', function ($customer) {
                return view('admin.backend.customer._action', compact('customer'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
