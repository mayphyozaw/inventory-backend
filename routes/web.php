<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\ReturnPurchaseController;
use App\Http\Controllers\Backend\SaleController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\WareHouseController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/logout',[AdminController::class, 'adminLogout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::resource('admin-user',AdminUserController::class);
    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');

});

Route::middleware('auth')->group(function (){
    Route::resource('brand',BrandController::class);
    Route::get('brand-datatable', [BrandController::class, 'brandDatatable'])->name('brand-datatable');


    Route::resource('warehouse', WareHouseController::class);
    Route::get('warehouse-datatable', [WareHouseController::class, 'warehouseDatatable'])->name('warehouse-datatable');

    Route::resource('supplier', SupplierController::class);
    Route::get('supplier-datatable', [SupplierController::class, 'supplierDatatable'])->name('supplier-datatable');
    
    Route::resource('customer', CustomerController::class);
    Route::get('customer-datatable', [CustomerController::class, 'customerDatatable'])->name('customer-datatable');
    
    Route::resource('category', CategoryController::class);
    Route::get('category-datatable', [CategoryController::class, 'categoryDatatable'])->name('category-datatable');

    Route::resource('product', ProductController::class);
    Route::get('product-datatable', [ProductController::class, 'productDatatable'])->name('product-datatable');

    Route::resource('purchase', PurchaseController::class);
    Route::get('purchase-datatable', [PurchaseController::class, 'purchaseDatatable'])->name('purchase-datatable');
    Route::get('/purchase/product/search', [PurchaseController::class, 'queryBySearch'])->name('purchase-product-search');
    Route::get('/invoice/purchase/{id}', [PurchaseController::class, 'invoicePurchase'])->name('invoice.purchase');


    Route::resource('return-purchase', ReturnPurchaseController::class);
    Route::get('return-purchase-datatable', [ReturnPurchaseController::class, 'returnPurchaseDatatable'])->name('return-purchase-datatable');
    Route::get('/invoice/return-purchase/{id}', [ReturnPurchaseController::class, 'invoiceReturnPurchase'])->name('invoice.return-purchase');


    Route::resource('sale', SaleController::class);
    Route::get('sale-datatable', [SaleController::class, 'saleDatatable'])->name('sale-datatable');


});