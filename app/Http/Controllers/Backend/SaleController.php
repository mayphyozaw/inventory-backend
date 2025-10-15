<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\WareHouse;
use App\Repositories\SaleRepository;
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

}
