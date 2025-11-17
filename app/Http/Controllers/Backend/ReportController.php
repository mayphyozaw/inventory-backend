<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ReturnPurchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function allReport()
    {
        $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse'])->get();
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        return view('admin.backend.report.all-report', compact('purchases', 'purchaseAll', 'purchaseReturnAll', 'productAll', 'saleAll', 'saleReturnAll'));
    }


    // public function filterPurchases(Request $request)
    // {
    //     $start = $request->start_date;
    //     $end   = $request->end_date;

    //     // Validate
    //     if (!$start || !$end) {
    //         return response()->json(['error' => 'Invalid date range'], 400);
    //     }

    //     // Query purchase with items and relations
    //     $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse'])
    //         ->whereBetween('date', [$start, $end])
    //         ->get();

    //     // Must return proper key "purchase_items" for JS
    //     $formatted = $purchases->map(function ($p) {
    //         return [
    //             'id' => $p->id,
    //             'date' => $p->date,
    //             'status' => $p->status,
    //             'grand_total' => $p->grand_total,
    //             'supplier' => $p->supplier,
    //             'warehouse' => $p->warehouse,
    //             'purchase_items' => $p->purchaseItems,
    //         ];
    //     });

    //     return response()->json([
    //         'purchases' => $formatted
    //     ]);
    // }


    public function filterPurchases(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Purchase::with(['purchaseItems.product','supplier','warehouse']);

        if($startDate & $endDate){
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date',[$startDate, $endDate]);
        }
        $purchases = $query->get();
        return response()->json(['purchases' => $purchases]);
    }


    public function purchaseRetrunReport(Request $request)
    {
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        $returnPurchases = ReturnPurchase::with(['purchaseItems.product','supplier','warehouse'])->get();
        return view('admin.backend.report.purchase_return_report', compact('returnPurchases','purchaseAll', 'purchaseReturnAll', 'productAll', 'saleAll', 'saleReturnAll'));
    }

    public function salesReport(Request $request)
    {
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        $saleReports = Sale::with(['saleItems.product','customer','warehouse'])->get();
        return view('admin.backend.report.sale_report',compact('saleReports','purchaseAll', 'purchaseReturnAll', 'productAll', 'saleAll', 'saleReturnAll'));
    }

    public function filterSales(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Sale::with(['saleItems.product','customer','warehouse']);

        if($startDate & $endDate){
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date',[$startDate, $endDate]);
        }
        $saleReports = $query->get();
        return response()->json(['saleReports' => $saleReports]);
    }

    public function salesRetrunReport(Request $request)
    {
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        $returnSales = SaleReturn::with(['saleReturnItems.product','customer','warehouse'])->get();
        return view('admin.backend.report.sales_return_report', compact('returnSales','purchaseAll', 'purchaseReturnAll', 'productAll', 'saleAll', 'saleReturnAll'));
    }
    

    public function productStockReport()
    {
        $purchaseAll = Purchase::count();
        $purchaseReturnAll = ReturnPurchase::count();
        $productAll = Product::count();
        $saleAll = Sale::count();
        $saleReturnAll = SaleReturn::count();
        $products = Product::with(['productCategory','warehouse'])->get();
        return view('admin.backend.report.stock_report',compact('products','purchaseAll', 'purchaseReturnAll', 'productAll', 'saleAll', 'saleReturnAll'));
    }

}
