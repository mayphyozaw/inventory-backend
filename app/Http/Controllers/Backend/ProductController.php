<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Repositories\ProductRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.product.index', compact('product'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $warehouses = WareHouse::all();
        $suppliers = Supplier::all();

        return view('admin.backend.product.create', compact('categories', 'brands', 'warehouses', 'suppliers'));
    }

    public function store(ProductStoreRequest $request)
    {

        try {
            $product = $this->productRepository->create([
                'name'  => $request->name,
                'code'  => $request->code,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'warehouse_id' => $request->warehouse_id,
                'supplier_id' => $request->supplier_id,
                'price' => $request->price,
                'stock_alert' => $request->stock_alert,
                'note' => $request->note,
                'product_qty' => $request->product_qty,
                'discount' => $request->discount ?? null,
                'status' => $request->status ?? null,
                'active' => 'pending',
            ]);


            if ($request->hasFile('images')) {
                $product_img_files = $request->file('images');
                foreach ($product_img_files as $key => $product_img_file) {
                    $product_img_name = uniqid() . '_' . time() . '.' . $product_img_file->getClientOriginalExtension();
                    $product_img_file->move(public_path('upload/product_images'), $product_img_name);

                    $product_img = new ProductImage();
                    $product_img->product_id = $product->id;
                    $product_img->image = $product_img_name;
                    $product_img->save();
                }
            }

            return Redirect::route('product.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function productDatatable(Request $request)
    {
        return $this->productRepository->productDatatable($request);
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.backend.product.edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->productRepository->update($id, [
                'category_name'  => $request->category_name,

            ]);
            DB::commit();
            return redirect()->route('product.index')->with([
                'message' => 'Supplier updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
