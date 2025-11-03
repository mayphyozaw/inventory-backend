<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\WareHouse;
use App\Repositories\SaleReturnRepository;
use App\Services\ResponseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    protected $saleReturnRepository;

    public function __construct(SaleReturnRepository $saleReturnRepository)
    {
        $this->saleReturnRepository = $saleReturnRepository;
    }


    public function index()
    {
        $saleReturnData = SaleReturn::orderBy('id', 'desc')->get();
        return view('admin.backend.sale-return.index', compact('saleReturnData'));
    }

    public function create()
    {
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sale-return.create', compact('customers', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required',

        ]);

        try {


            $sale = SaleReturn::create([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'customer_id' => $request->customer_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note ?? '',
                'grand_total' => $request->grand_total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount ?? 0,
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


                SaleReturnItem::create([
                    'date' => date('Y-m-d'),
                    'sale_return_id' => $sale->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty + $productData['quantity'],
                    'quantity' => $productData['quantity'],
                    'discount' => $productData['discount'],
                    'subtotal' => $subtotal,
                ]);

                $product->increment('product_qty', $productData['quantity']);
            }

            $sale->update(['grand_total' => $grandTotal + $request->shipping - $request->discount]);

            return redirect()->route('sale-return.index')->with([
                'message' => 'Sale Return Stored successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function saleReturnDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->saleReturnRepository->saleReturnDatatable($request);
        }
    }

    public function edit($id)
    {
        $editSaleReturnData = SaleReturn::with('saleReturnItems.product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.sale-return.edit', compact('editSaleReturnData', 'customers', 'warehouses'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
        ]);

        $saleReturn = SaleReturn::findOrFail($id);
        $saleReturn->update([
            'date' => $request->date,
            'warehouse_id' => $request->warehouse_id,
            'customer_id' => $request->customer_id,
            'discount' => $request->discount ?? 0,
            'shipping' => $request->shipping ?? 0,
            'status' => $request->status,
            'note' => $request->note ?? '',
            'grand_total' => $request->grand_total,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount ?? 0,
        ]);

        // Delete old sales item
        SaleReturnItem::where('sale_return_id', $saleReturn->id)->delete();

        foreach ($request->products as $product_id => $productData) {
            SaleReturnItem::create([
                'date' => $request->date,
                'sale_return_id' => $saleReturn->id,
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
            'message' => 'Sale Return Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('sale-return.index')->with($notification);
    }

    public function destroy($id)
    {
        try {
            $saleReturn = SaleReturn::findOrFail($id);
            $saleIReturntems = SaleReturnItem::where('sale_return_id', $id)->get();

            foreach ($saleIReturntems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('product_qty', $item->quantity);
                }
            }
            SaleReturnItem::where('sale_return_id', $id)->delete();
            $saleReturn->delete();

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
           
        }
    }

       public function show($id)
    {
        $saleReturn = SaleReturn::with(['customer','saleReturnItems.product'])->find($id);
        
        return view('admin.backend.sale-return.show', compact('saleReturn'));
    }

    public function invoiceSaleReturn($id)
   {
        $saleReturn = SaleReturn::with(['customer', 'warehouse', 'saleReturnItems.product'])->find($id);
        $pdf = Pdf::loadView('admin.backend.sale-return.invoice_pdf',compact('saleReturn'));
        return $pdf->download('sale_return_' . $id. '.pdf');
    }
}
