<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = ProductCategory::class;
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

    public function productDatatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->addIndexColumn() 
            ->editColumn('category_slug', function ($productCategory) {
            return strtolower(str_replace(' ', '-', $productCategory->category_name));
            })
            ->addColumn('action', function ($productCategory) {
                return view('admin.backend.productCategory._action', compact('productCategory'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
