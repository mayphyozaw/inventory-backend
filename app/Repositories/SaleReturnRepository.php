<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ReturnPurchase;
use App\Models\SaleReturn;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class SaleReturnRepository implements BaseRepository
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

   

     public function saleReturnDatatable(Request $request)
    {
        $model = $this->model::query();


        return DataTables::eloquent($model)
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('warehouse', function ($saleReturn) {
                return $saleReturn->warehouse->name ?? '';
            })
            ->editColumn('status', function ($saleReturn) {

                return '<span class="badge" style="background-color:#' . $saleReturn->acsrStatus['color'] . '; color:#fff;">' . $saleReturn->acsrStatus['text'] . '</span>';
            })
            ->editColumn('paid_amount', function ($saleReturn) {
                
                return '<span class="badge bg-info" style="font-size:14px;">$' . number_format($saleReturn->paid_amount, 2) . '</span>';
            })
            ->editColumn('due_amount', function ($saleReturn) {
                // return '<span class="badge bg-success">$' . number_format($sale->due_amount, 2) . '</span>';
                // return '$' . number_format($sale->due_amount, 2);
                return '<span class="badge bg-secondary" style="font-size:14px;">$' . number_format($saleReturn->due_amount, 2) . '</span>';
            })
            ->editColumn('grand_total', function ($saleReturn) {
                
                return '$' . number_format($saleReturn->grand_total, 2);

            })
            ->editColumn('created_at', function ($saleReturn) {
                return Carbon::parse($saleReturn->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($saleReturn) {
                return view('admin.backend.sale-return._action', compact('saleReturn'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['status','paid_amount','due_amount','grand_total', 'action'])
            ->make(true);
    }
}
