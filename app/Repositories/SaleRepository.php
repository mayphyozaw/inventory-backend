<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class SaleRepository implements BaseRepository
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

    public function saleDatatable(Request $request)
    {
        $model = $this->model::query();


        return DataTables::eloquent($model)
            ->filterColumn('customer', function ($query, $keyword) {
                $query->whereHas('customer', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('warehouse', function ($sale) {
                return $sale->warehouse->name ?? '';
            })
            ->editColumn('status', function ($sale) {
                
                return '<span class="badge" style="background-color:#' . $sale->acsrStatus['color'] . '; color:#fff;">' . $sale->acsrStatus['text'] . '</span>';
            })
            ->editColumn('due_amount', function ($sale) {
                return '$' . number_format($sale->due_amount,2); 
            })
            ->editColumn('grand_total', function ($sale) {
                return '<span class="badge text-bg-secondary" $' . number_format($sale->grand_total,2) . '</span>';
            })
            ->editColumn('created_at', function ($sale) {
                return Carbon::parse($sale->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($sale) {
                return view('admin.backend.sale._action', compact('sale'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['status', 'stock_alert', 'action'])
            ->make(true);
    }
}
