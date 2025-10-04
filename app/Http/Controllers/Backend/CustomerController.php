<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
   
     protected $customerRepository;

     public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customer = Customer::all();
        return view('admin.backend.customer.index',compact('customer'));
    }

    public function create()
    {
        return view('admin.backend.customer.create');
    }

    public function store(CustomerStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->customerRepository->create([
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'address'  => $request->address,
            ]);

            DB::commit();
            return Redirect::route('customer.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function customerDatatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->customerRepository->customerDatatable($request);
        }
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.backend.customer.edit', compact('customer')); 
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->customerRepository->update($id, [
                'name'  => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'address'  => $request->address,
            ]);
            DB::commit();
            return redirect()->route('customer.index')->with([
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
            $this->customerRepository->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }

}
