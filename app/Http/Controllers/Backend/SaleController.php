<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\WareHouse;
use App\Repositories\SaleRepository;
use App\Services\ResponseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }


    public function index()
    {
        $saleData = Sale::orderBy('id', 'desc')->get();
        return view('admin.backend.sale.index', compact('saleData'));
    }

    public function create()
    {
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sale.create', compact('customers', 'warehouses'));
    }


    public function saleDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->saleRepository->saleDatatable($request);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required',

        ]);

        try {

            $grandTotal = 0;
            $sales = Sale::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note ?? '',
                'grand_total' => $request->grand_total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
            ]);


            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $product['net_unit_cost'] ?? $product->price;
                if ($netUnitCost === null) {
                    throw new \Exception("Net Unit Cost is missing for the product id" . $productData['id']);
                }
                $subtotal = ($netUnitCost * $productData['quantity']) - ($productData['discount'] ?? 0);
                $grandTotal += $subtotal;


                SaleItem::create([
                    'date' => date('Y-m-d'),
                    'sale_id' => $sales->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'],
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('product_qty', $productData['quantity']);
            }

            $sales->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);

            return redirect()->route('sale.index')->with([
                'message' => 'Sale Stored successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {

        $editSaleData = Sale::with('saleItems.product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sale.edit', compact('editSaleData', 'customers', 'warehouses'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update([
            'date' => $request->date,
            'warehouse_id' => $request->warehouse_id,
            'customer_id' => $request->customer_id,
            'discount' => $request->discount ?? 0,
            'shipping' => $request->shipping ?? 0,
            'status' => $request->status,
            'note' => $request->note,
            'grand_total' => $request->grand_total,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
            'full_paid' => $request->full_paid,
        ]);

        // Delete old sales item
        SaleItem::where('sale_id', $sale->id)->delete();

        foreach ($request->products as $product_id => $productData) {
            SaleItem::create([
                'date' => $request->date,
                'sale_id' => $sale->id,
                'product_id' => $product_id,
                'net_unit_cost' => $productData['net_unit_cost'],
                'stock' => $productData['stock'],
                'quantity' => $productData['quantity'],
                'discount' => $productData['discount'] ?? 0,
                'subtotal' => $productData['subtotal'],
            ]);

            /// Update Product Stock

            $product = Product::find($product_id);
            if ($product) {
                $qty = $product->product_qty;
                $product->product_qty = $qty += $productData['quantity'];
                $product->save();
            }
        }

        $notification = array(
            'message' => 'Sale Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('sale.index')->with($notification);
    }
    // End Method 

    public function destroy($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $saleItems = SaleItem::where('sale_id', $id)->get();

            foreach ($saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('product_qty', $item->quantity);
                }
            }
            SaleItem::where('sale_id', $id)->delete();
            $sale->delete();

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
            // return response()->json(['error'=>$e->getMessage()],500);
        }
    }

       public function show($id)
    {
        $sale = Sale::with(['customer','saleItems.product'])->find($id);
        
        return view('admin.backend.sale.show', compact('sale'));
    }

    public function invoiceSale($id)
   {
        $sale = Sale::with(['customer', 'warehouse', 'saleItems.product'])->find($id);
        $pdf = Pdf::loadView('admin.backend.sale.invoice_pdf',compact('sale'));
        return $pdf->download('sale_' . $id. '.pdf');
    }

}
