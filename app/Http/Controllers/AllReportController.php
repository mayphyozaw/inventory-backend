<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ReturnPurchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllReportController extends Controller
{
    public function dashboard()
    {
        $brandAll = Brand::count();
        $warehouseAll = WareHouse::count();
        $supplierAll = Supplier::count();
        $customerAll = Customer::count();
        // $saleAll = Sale::count();


        $monthlySales = Sale::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($row) {

                $monthName = date("M", mktime(0, 0, 0, $row->month, 1));
                // $monthName = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                return [

                    'label' => $monthName,   // Oct, Nov, Dec
                    'total' => $row->total
                ];
            });
// -------------------******-------------------------
        $allMonths = collect([
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ]);

        $raw = Purchase::selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

       $rawData = $raw->pluck('total', 'month');

        $monthlyPurchases = $allMonths->map(function ($label, $index) use ($rawData) {
            $monthNumber = $index + 1; // 1–12
            return [
                'label' => $label,
                'value' => $rawData[$monthNumber] ?? 0, // 0 if no data
            ];
        });

        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $userAll = User::count();
        return view('admin.index', compact('brandAll', 'warehouseAll', 'supplierAll', 'customerAll', 'monthlySales', 'monthlyPurchases','productAll','saleReturnAll','saleAll','purchaseAll','purchaseReturnAll','userAll'));
    }
}
