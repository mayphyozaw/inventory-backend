<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Purchase;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class PurchaseRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Purchase::class;
        return  $this->model = Purchase::class;
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

    public function purchaseDatatable(Request $request)
    {
        $model = $this->model::query();


        return DataTables::eloquent($model)
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('warehouse', function ($purchase) {
                return $purchase->warehouse->name ?? '';
            })
            ->editColumn('status', function ($purchase) {
                
                return '<span class="badge" style="background-color:#' . $purchase->acsrStatus['color'] . '; color:#fff;">' . $purchase->acsrStatus['text'] . '</span>';
            })
            ->editColumn('payment', function () {
                return 'cash';
            })
            ->editColumn('grand_total', function ($purchase) {
                return '$' . number_format($purchase->grand_total,2);
            })
            ->editColumn('created_at', function ($purchase) {
                return Carbon::parse($purchase->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($purchase) {
                return view('admin.backend.purchase._action', compact('purchase'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['status', 'stock_alert', 'action'])
            ->make(true);
    }
}
