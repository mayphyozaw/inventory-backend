<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Brand::class;
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

        if (!$data['image']) {
            $data['image'] = $record->image;
        } else {
            if ($record['image'] && file_exists(public_path('upload/brand_images/' . $record['image']))) {
                unlink(public_path('upload/brand_images/' . $record['image']));
            }
        }

        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
    }


    public function brandDatatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->addIndexColumn() // generates DT_RowIndex
            ->editColumn('image', function ($brand) {
                $imagePath = $brand->acsrImagePath
                    ? $brand->acsrImagePath
                    : asset('upload/brand_images/default.png');

                return '<img src="' . e($imagePath) . '" alt="Brand Image" 
                        style="width:40px; height:40px; object-fit:cover; border-radius:4px;">';
            })
            ->addColumn('action', function ($brand) {
                return view('admin.backend.brand._action', compact('brand'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
