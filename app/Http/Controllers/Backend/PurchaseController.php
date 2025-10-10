<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Repositories\PurchaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    }


    public function purchaseDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->purchaseRepository->purchaseDatatable($request);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'supplier_id' => 'required',
        ]);

        try {

            $purchase = Purchase::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note ?? '',
                'grand_total' => $request->grand_total,
            ]);

            $grandTotal = 0;

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $product['net_unit_cost'] ?? $product->price;

                if($netUnitCost === null){
                    throw new \Exception("Net Unit Cost is missing for the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'],
                    'subtotal' => $subtotal,
                ]); 

                $product->increment('product_qty', $productData['quantity']);
            }

            $purchase->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);
            
            return redirect()->route('purchase.index')->with([
                'message' => 'Purchase Stored successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
