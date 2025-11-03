<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleReturn;
use App\Repositories\SaleDueRepository;
use App\Repositories\SaleReturnDueRepository;
use Illuminate\Http\Request;

class DueController extends Controller
{   
    
    protected $saleDueRepository, $saleReturnDueRepository;

    public function __construct(SaleDueRepository $saleDueRepository, SaleReturnDueRepository $saleReturnDueRepository)
    {
        $this->saleDueRepository = $saleDueRepository;
        $this->saleReturnDueRepository = $saleReturnDueRepository;
    }

    
    public function dueSale()
    {
        
        $sales = Sale::with(['customer','warehouse'])
                ->select('id','customer_id','warehouse_id','due_amount')
                ->where('due_amount','>', 0)
                ->get();
        return view("admin.backend.due.sale_due",compact('sales'));
    }


    public function saleDueDatatable(Request $request)
    {
        
        if ($request->ajax()) {
            return $this->saleDueRepository->saleDueDatatable($request);
        }
    }

    public function dueSaleReturn()
    {
        $sales = SaleReturn::with(['customer','warehouse'])
                ->select('id','customer_id','warehouse_id','due_amount')
                ->where('due_amount', '>', 0)
                ->get();
        return view('admin.backend.due.sale_return_due',compact('sales'));
    }

    public function saleReturnDueDatatable(Request $request)
    {
        
        if ($request->ajax()) {
            return $this->saleReturnDueRepository->saleReturnDueDatatable($request);
        }
    }
}
