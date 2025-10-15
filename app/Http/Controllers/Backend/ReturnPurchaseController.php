<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ReturnPurchase;
use App\Models\ReturnPurchaseItem;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Repositories\ReturnPurchaseRepository;
use App\Services\ResponseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class ReturnPurchaseController extends Controller
{
    protected $returnPurchaseRepository;

    public function __construct(ReturnPurchaseRepository $returnPurchaseRepository)
    {
        $this->returnPurchaseRepository = $returnPurchaseRepository;
    }
    
    public function index()
    {
        $returnPurchaseData = ReturnPurchase::orderBy('id', 'desc')->get();
        return view('admin.backend.return-purchase.index', compact('returnPurchaseData'));
    }


    public function returnPurchaseDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->returnPurchaseRepository->returnPurchaseDatatable($request);
        }
    }

     public function create()
    {
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.return-purchase.create', compact('suppliers', 'warehouses'));
    }

     public function store(Request $request)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'supplier_id' => 'required',
        ]);

        try {

            $purchase = ReturnPurchase::create([
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

                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit Cost is missing for the product id" . $productData['id']);
                }

                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;
     

                ReturnPurchaseItem::create([
                    'return_purchase_id' => $purchase->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'],
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('product_qty', $productData['quantity']);
            }

            $purchase->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);

            return redirect()->route('return-purchase.index')->with([
                'message' => 'Return Purchase Stored successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $returnPurchase = ReturnPurchase::with(['supplier','returnPurchaseItems.product'])->find($id);
        
        return view('admin.backend.return-purchase.show', compact('returnPurchase'));
    }

    public function edit($id)
    {
        $editReturnPurchaseData = ReturnPurchase::with('returnPurchaseItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.return-purchase.edit',compact('editReturnPurchaseData','suppliers','warehouses'));
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'date' => 'required|date',
            'status' => 'required',
            'supplier_id' => 'required',
        ]);


        try {

            $returnPurchase = ReturnPurchase::findOrFail($id);
            $returnPurchase->update([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note ?? '',
                'grand_total' => $request->grand_total,
            ]);

            $oldReturnPurchaseItems = ReturnPurchaseItem::where('return_purchase_id', $returnPurchase->id)->get();

            foreach ($oldReturnPurchaseItems as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('product_qty', $oldItem->quantity);
                }
            }

            ReturnPurchaseItem::where('return_purchase_id', $returnPurchase->id)->delete();

            foreach ($request->products as $product_id => $productData) {
                ReturnPurchaseItem::create([
                    'return_purchase_id' => $returnPurchase->id,
                    'product_id' => $product_id,
                    'net_unit_cost' => $productData['net_unit_cost'],
                    'stock' => $productData['stock'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'] ?? 0,
                    'subtotal' => $productData['subtotal'],
                ]);
                //update

                $product =  Product::find($product_id);
                if ($product) {
                    $product->decrement('product_qty', $productData['quantity']);
                }
            }

            return redirect()->route('return-purchase.index')->with([
                'message' => 'Return Purchase Updatd successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $returnPurchase = ReturnPurchase::findOrFail($id);
            $returnPurchaseItems = ReturnPurchaseItem::where('return_purchase_id',$id)->get();

            foreach ($returnPurchaseItems as $item) {
                $product = Product::find($item->product_id);
                if($product){
                    $product->increment('product_qty',$item->quantity);
                }
            }
            ReturnPurchaseItem::where('return_purchase_id',$id)->delete();
            $returnPurchase->delete();
            
            return ResponseService::success([], 'Successfully deleted');
            
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
            // return response()->json(['error'=>$e->getMessage()],500);
        }
    }


    public function invoiceReturnPurchase($id)
    {
        $purchase = ReturnPurchase::with(['supplier', 'warehouse', 'returnPurchaseItems.product'])->find($id);
        $pdf = Pdf::loadView('admin.backend.return-purchase.invoice_pdf',compact('purchase'));
        return $pdf->download('return-purchase_' . $id. '.pdf');

    }
     
}
