<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Transfer;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Yajra\DataTables\Facades\DataTables;

class TransferRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Transfer::class;
        return  $this->model = Transfer::class;
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

   

     public function transferDatatable(Request $request)
    {
        $model = $this->model::query();


        return DataTables::eloquent($model)
            ->filterColumn('warehouse', function ($query, $keyword) {
                $query->whereHas('warehouse', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', "%$keyword%");
                });
            })
            ->addIndexColumn()
            ->editColumn('created_at', function ($transfer) {
                return Carbon::parse($transfer->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('fromWarehouse', function ($transfer) {
                return $transfer->fromWarehouse->name ?? '';
            })
            ->editColumn('toWarehouse', function ($transfer) {
                return $transfer->toWarehouse->name ?? '';
            })

            ->editColumn('product', function ($transfer) {
                return view('admin.backend.transfer._product', compact('transfer'))->render();
            })

            ->editColumn('stock', function ($transfer) {
                return view('admin.backend.transfer._stock_qty', compact('transfer'))->render();
                // return $transfer->toWarehouse->name ?? '';

            })
            
            ->addColumn('action', function ($transfer) {
                return view('admin.backend.transfer._action', compact('transfer'))->render();
            })
            ->addColumn('responsive-icon', function () {
                return null;
            })
            ->rawColumns(['action', 'product', 'stock'])
            ->make(true);
    }
}
