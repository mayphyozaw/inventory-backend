<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\WareHouse\WareHouseStoreRequest;
use App\Http\Requests\WareHouse\WareHouseUpdateRequest;
use App\Models\WareHouse;
use App\Repositories\WareHouseRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class WareHouseController extends Controller
{
    protected $warehouseRepository;

    public function __construct(WareHouseRepository $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function index()
    {
        $warehouse = WareHouse::all();
        return view('admin.backend.warehouse.index', compact('warehouse'));
    }

    public function create()
    {
        return view('admin.backend.warehouse.create');
    }

    public function store(WareHouseStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->warehouseRepository->create([
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'city'  => $request->city,
            ]);

            DB::commit();
            return Redirect::route('warehouse.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

     public function warehouseDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->warehouseRepository->warehouseDatatable($request);
        }
    }

    public function edit($id)
    {
        $warehouse = WareHouse::findOrFail($id);
        return view('admin.backend.warehouse.edit', compact('warehouse')); 
    }

    public function update(WareHouseUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->warehouseRepository->update($id, [
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'city'  => $request->city,
            ]);
            DB::commit();
            return redirect()->route('warehouse.index')->with([
                'message' => 'WareHouse updated successfully!',
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
            $this->warehouseRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
