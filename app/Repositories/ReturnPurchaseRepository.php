<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ReturnPurchase;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class ReturnPurchaseRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = ReturnPurchase::class;
        return  $this->model = ReturnPurchase::class;
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

    public function returnPurchaseDatatable(Request $request)
    {
        $model = $this->model::query();


        return DataTables::eloquent($model)
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('warehouse', function ($returnPurchase) {
                return $returnPurchase->warehouse->name ?? '';
            })
            ->editColumn('status', function ($returnPurchase) {
                
                return '<span class="badge" style="background-color:#' . $returnPurchase->acsrStatus['color'] . '; color:#fff;">' . $returnPurchase->acsrStatus['text'] . '</span>';
            })
            ->editColumn('payment', function () {
                return 'cash';
            })
            ->editColumn('grand_total', function ($returnPurchase) {
                return '$' . number_format($returnPurchase->grand_total,2);
            })
            ->editColumn('created_at', function ($returnPurchase) {
                return Carbon::parse($returnPurchase->created_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($returnPurchase) {
                return view('admin.backend.return-purchase._action', compact('returnPurchase'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['status', 'stock_alert', 'action'])
            ->make(true);
    }
}
