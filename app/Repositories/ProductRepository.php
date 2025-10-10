<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Product::class;
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

    public function queryById($product)
    {
        return $this->model::where('product_id',$product->id);
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
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('image', function ($product) {
                if ($product->productImages->isNotEmpty()) {
                    $images = '';
                    foreach ($product->productImages as $key => $image) {
                        $imagePath = $image->acsrImagePath;
                        $images .= '<img src="' . e($imagePath) . '" alt="Brand Image" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">';
                    }

                    return $images;
                }
                return '<img src="' . asset('upload/no_image.jpg') . '" width="50" style="margin-right:5px; border-radius:5px;">';
            })
            ->editColumn('stock_alert', function ($product) {
                $badgeClass = $product->product_qty <= 3 ? 'text-bg-danger' : 'text-bg-secondary';
                return '<span class="badge ' . $badgeClass . '"style="font-size: 14px;">' . e($product->product_qty) . '</span>';
            })

            ->editColumn('warehouse', function ($product) {
                return $product->warehouse->name ?? '';
            })

            ->addColumn('action', function ($product) {
                return view('admin.backend.product._action', compact('product'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['image', 'stock_alert', 'action'])
            ->make(true);
    }
}
