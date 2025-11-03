<?php

namespace App\Repositories;


use App\Models\Sale;
use App\Models\SaleReturn;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class SaleReturnDueRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = SaleReturn::class;
        return  $this->model = SaleReturn::class;
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

    public function saleReturnDueDatatable(Request $request)
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
            ->editColumn('warehouse', function ($saleReturnDue) {
                return $saleReturnDue->warehouse->name ?? '';
            })
            ->editColumn('customer', function ($saleReturnDue) {
                return $saleReturnDue->customer->name ?? '';
            })
            ->editColumn('due_amount', function ($saleReturnDue) {

                return '<span class="badge bg-secondary" style="font-size:14px;">$' . number_format($saleReturnDue->due_amount, 2) . '</span>';
            })


            ->addColumn('action', function ($saleReturn) {
                return view('admin.backend.due.sale_return_due_action', compact('saleReturn'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['due_amount', 'action'])
            ->make(true);
    }
}
