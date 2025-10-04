<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierStoreRequest;
use App\Http\Requests\Supplier\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
     protected $supplierRepository;

     public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.backend.supplier.index',compact('supplier'));
    }

    public function create()
    {
        return view('admin.backend.supplier.create');
    }

    public function store(SupplierStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->supplierRepository->create([
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'address'  => $request->address,
            ]);

            DB::commit();
            return Redirect::route('supplier.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function supplierDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->supplierRepository->supplierDatatable($request);
        }
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.backend.supplier.edit', compact('supplier')); 
    }

    public function update(SupplierUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->supplierRepository->update($id, [
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'address'  => $request->address,
            ]);
            DB::commit();
            return redirect()->route('supplier.index')->with([
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
            $this->supplierRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
