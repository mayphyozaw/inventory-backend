<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\TransferItem;
use App\Models\WareHouse;
use App\Repositories\TransferRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransferController extends Controller
{
    protected $transferRpository;

    public function __construct(TransferRepository $transferRpository)
    {
        $this->transferRpository = $transferRpository;
    }

    public function index()
    {
        $allData = Transfer::with(['transferItems.product'])->orderBy('id', 'desc')->get();
        return view('admin.backend.transfer.index', compact('allData'));
    }

    public function transferDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->transferRpository->transferDatatable($request);
        }
    }

    public function create()
    {
        $warehouses = WareHouse::all();
        return view('admin.backend.transfer.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
        ]);

        try {
            $transfer = Transfer::create([
                'date' => $request->date,
                'from_warehouse_id' => $request->from_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note ?? '',
                'grand_total' => 0,
            ]);

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);
                $netUnitCost = $product->price;
                $quantity = $productData['quantity'];
                $discount = $productData['discount'];
                $subtotal = ($netUnitCost * $quantity) - $discount;

                TransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $productData['id'],
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

                // Decrement stock from "from_warehouse'
                Product::where('id', $productData['id'])
                    ->where('warehouse_id', $request->from_warehouse_id)
                    ->decrement('product_qty', $quantity);

                // Check if the product exist  in to_warehouse
                $existingProduct = Product::where('name', $product->name)
                    ->where('brand_id', $product->brand_id)
                    ->where('warehouse_id', $request->to_warehouse_id)
                    ->first();

                if ($existingProduct) {
                    $existingProduct->increment('product_qty', $quantity);
                } else {
                    //if not exist then we create new product without code
                    Product::create([
                        'name' => $product->name,
                        'brand_id' => $product->brand_id,
                        'warehouse_id' => $request->to_warehouse_id,
                        'price' => $product->price,
                        'product_qty' => $quantity,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->route('transfer.index')->with([
                'message' => 'Transfers Complete successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $editTransferData = Transfer::with('fromWarehouse', 'toWarehouse', 'transferItems.product')->findOrFail($id);
        $warehouses = WareHouse::all();
        return view('admin.backend.transfer.edit', compact('editTransferData', 'warehouses'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required',
        ]);

        try {

            $transfer = Transfer::findOrFail($id);
            $transfer->date = $request->date;
            $transfer->update();


            $oldItems = TransferItem::where('transfer_id', $id)->get();
            foreach ($oldItems as $oldItem) {
                Product::where('id', $oldItem->product_id)
                    ->where('warehouse_id', $transfer->from_warehouse_id)
                    ->increment('product_qty', $oldItem->quantity);
            }
            TransferItem::where('transfer_id', $id)->delete();



            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                $netUnitCost = $product->price;
                $quantity = $productData['quantity'];
                $discount = $productData['discount'];
                $subtotal = ($netUnitCost * $quantity) - $discount;
                $product->product_qty = $product->product_qty - $quantity;
                $product->update();

                TransferItem::create([
                    'transfer_id' => $transfer->id,
                    'product_id' => $product->id,
                    'net_unit_cost' => $netUnitCost,
                    'stock' => $product->product_qty,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

                Product::updateOrCreate(
                    [
                        'name' => $product->name,
                        'brand_id' => $product->brand_id,
                        'warehouse_id' => $request->to_warehouse_id,
                    ],
                    [
                        'price' => $product->price,
                        'product_qty' => $quantity,
                        'status' => 1,
                        'updated_at' => now(),
                    ]
                );
            }

            return redirect()->route('transfer.index')->with([
                'message' => 'Transfers Complete successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            
            $transfer = Transfer::findOrFail($id);
            $transferItems = TransferItem::where('transfer_id', $id)->get();
            foreach ($transferItems as $item) {
                Product::where('id', $item->product_id)
                    ->where('warehouse_id', $transfer->from_warehouse_id)
                    ->increment('product_qty', $item->quantity);

                    Product::where('warehouse_id', $transfer->to_warehouse_id)
                    ->decrement('product_qty', $item->quantity);
            }
            TransferItem::where('transfer_id', $id)->delete();
            $transfer->delete();

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
           
        }
    }

    public function show($id)
    {
        $transfer = Transfer::with(['transferItems.product'])->findOrFail($id);
        $product = Product::find($transfer->product_id);
        $fromWarehouse = WareHouse::find($transfer->from_warehouse_id);
        $toWarehouse = WareHouse::find($transfer->to_warehouse_id);
        return view('admin.backend.transfer.show', compact('transfer','product','fromWarehouse','toWarehouse'));
    }
}
