<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function index()
    {
        $purchaseData = Purchase::orderBy('id', 'desc')->get();
        return view('admin.backend.purchase.index', compact('purchaseData'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.purchase.create', compact('suppliers', 'warehouses'));
    }

    public function queryBySearch(Request $request)
    {

        $query = $request->input('query');
        $warehouse_id = $request->input('warehouse_id');
        $products = Product::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('code', 'LIKE', "%{$query}%");
        })
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', $warehouse_id);
            })
            ->select('id', 'name', 'code', 'price', 'product_qty')
            ->limit(10)
            ->get();
        return response()->json($products);

        // $products = $this->purchaseRepository->queryById($product)
        //     ->when($request->search, function ($q) use ($request) {
        //         $q->where('name', 'LIKE', "%$request->search%")
        //             ->orWhere('code', 'LIKE', "%$request->search%");
        //     })
        //     ->when($warehouse_id, function ($q) use ($warehouse_id) {
        //         $q->where('warehouse_id', $warehouse_id);
        //     })
        //     ->select('id', 'name', 'code', 'price', 'product_qty')
        //     ->limit(10)
        //     ->get();
        // return response()->json($products);

        // $warehouse = Auth::guard('web')->warehouse();
        // $purchaseProducts = $this->purchaseRepository->queryById($warehouse)
        //     ->when($request->search, function ($q1) use ($request) {
        //         $q1->where('trx_id', 'LIKE', "%$request->search%")
        //             ->orWhere('amount', 'LIKE', "%$request->search%")
        //             ->orWhere('created_at', 'LIKE', "%$request->search%");
        //     })
        //     ->orderByDesc('id')
        //     ->paginate(10);
        // return TicketResource::collection($tickets)->additional(['message' => 'success']);
    }


    public function purchaseDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->purchaseRepository->purchaseDatatable($request);
        }
    }
}
