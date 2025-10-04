<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCategoryStoreRequest;
use App\Http\Requests\Product\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
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
        $productCategory = ProductCategory::all();
        return view('admin.backend.productCategory.index',compact('productCategory'));
    }

    public function create()
    {
        return view('admin.backend.productCategory.create');
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->productRepository->create([
                'category_name'  => $request->category_name,
                'category_slug'  => strtolower(str_replace('', '-',
                $request->category_name)),
            ]);

            DB::commit();
            return Redirect::route('product.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function productDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->productRepository->productDatatable($request);
        }
    }


    public function edit($id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        return view('admin.backend.productCategory.edit', compact('productCategory')); 
    }

    public function update(ProductCategoryUpdateRequest $request, $id)
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
