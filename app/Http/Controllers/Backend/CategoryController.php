<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\ProductCategory;
use App\Repositories\CategoryRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    protected $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    public function index()
    {
        $category = ProductCategory::all();
        return view('admin.backend.productCategory.index',compact('category'));
    }

    // public function create()
    // {
    //     return view('admin.backend.productCategory.create');
    // }

    public function store(CategoryStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->categoryRepository->create([
                'category_name'  => $request->category_name,
                'category_slug'  => strtolower(str_replace('', '-',
                $request->category_name)),
            ]);

            DB::commit();
            return Redirect::route('category.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function categoryDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->categoryRepository->categoryDatatable($request);
        }
    }


    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.backend.productCategory.edit', compact('category')); 
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->categoryRepository->update($id, [
                'category_name'  => $request->category_name,
                
            ]);
            DB::commit();
            return redirect()->route('category.index')->with([
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
            $this->categoryRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }

}

