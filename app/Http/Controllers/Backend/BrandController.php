<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandStoreRequest;
use App\Http\Requests\Brand\BrandUpdateRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepositoy)
    {
        $this->brandRepository = $brandRepositoy;
    }

    public function index()
    {
        $brandData = Brand::all();
        return view('admin.backend.brand.index', compact('brandData'));
    }

    public function create()
    {
        return view('admin.backend.brand.create');
    }

    public function store(BrandStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $brand_img_file = $request->file('image');
            $brand_img_name = uniqid() . '_' . time() . '.' . $brand_img_file->getClientOriginalExtension();
            $brand_img_file->move(public_path('upload/brand_images'), $brand_img_name);

            $this->brandRepository->create([
                'name'  => $request->name,
                'image' => $brand_img_name,
            ]);

            DB::commit();
            return Redirect::route('brand.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function brandDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->brandRepository->brandDatatable($request);
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.backend.brand.edit', compact('brand'));
    }

   
    public function update(BrandUpdateRequest $request, $id)
    {
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/brand_images'), $filename);
        }

        try {
            $this->brandRepository->update($id, [
                'name' => $request->name,
                'image' => $filename ?? null,
            ]);

            return redirect()->route('brand.index')->with([
                'message' => 'Brand updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    
    public function destroy($id)
    {
        try {
            $this->brandRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
