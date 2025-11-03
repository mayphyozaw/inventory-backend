<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class SaleDueRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Sale::class;
        return  $this->model = Sale::class;
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
        return $this->model::where('product_id', $product->id);
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

    public function saleDueDatatable(Request $request)
    {
        $model = $this->model::where('due_amount', '>', 0)
            ->with(['warehouse', 'customer']);


        return DataTables::eloquent($model)
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('warehouse', function ($saleDue) {
                return $saleDue->warehouse->name ?? '';
            })
            ->editColumn('customer', function ($saleDue) {
                return $saleDue->customer->name ?? '';
            })
            ->editColumn('due_amount', function ($saleDue) {

                return '<span class="badge bg-secondary" style="font-size:14px;">$' . number_format($saleDue->due_amount, 2) . '</span>';
            })


            ->addColumn('action', function ($sale) {
                return view('admin.backend.due._action', compact('sale'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['due_amount', 'action'])
            ->make(true);
    }
}
