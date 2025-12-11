<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AllReportController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReturnPurchaseController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\RoleHasPermissionController;
use App\Http\Controllers\Backend\SaleController;
use App\Http\Controllers\Backend\SaleReturnController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\TransferController;
use App\Http\Controllers\Backend\WareHouseController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Models\SaleReturn;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AllReportController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
// Route::post('/login', [AdminController::class, 'adminLogin'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile',[AdminController::class,'admin_profile'])->name('admin.profile');
    Route::post('/profile/store',[AdminController::class,'profile_store'])->name('profile.store');
    Route::post('/admin/password/update',[AdminController::class,'password_update'])->name('admin.password.update');

});

Route::middleware('auth')->group(function () {
    Route::resource('admin-user', AdminUserController::class);
    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');
});

Route::middleware('auth')->group(function () {
    Route::resource('brand', BrandController::class);
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
    Route::get('/invoice/sale/{id}', [SaleController::class, 'invoiceSale'])->name('invoice.sale');

    Route::resource('sale-return', SaleReturnController::class);
    Route::get('sale-return-datatable', [SaleReturnController::class, 'saleReturnDatatable'])->name('sale-return-datatable');
    Route::get('/invoice/sale-return/{id}', [SaleReturnController::class, 'invoiceSaleReturn'])->name('invoice.sale-return');


    Route::get('due/sale_due', [DueController::class, 'dueSale'])->name('due.sale_due');
    Route::get('saleDue-datatable', [DueController::class, 'saleDueDatatable'])->name('saleDue-datatable');
    Route::get('due/sale_return_due', [DueController::class, 'dueSaleReturn'])->name('due.sale_return_due');
    Route::get('saleReturnDue-datatable', [DueController::class, 'saleReturnDueDatatable'])->name('saleReturnDue-datatable');

    Route::resource('transfer', TransferController::class);
    Route::get('transfer-datatable', [TransferController::class, 'transferDatatable'])->name('transfer-datatable');

    Route::get('/all/report', [ReportController::class, 'allReport'])->name('all.report');
    Route::get('/purchase/return/report', [ReportController::class, 'purchaseRetrunReport'])->name('purchase.return.report');
    Route::get('/filter-purchases', [ReportController::class, 'filterPurchases']);

    Route::get('/sales/report', [ReportController::class, 'salesReport'])->name('sales.report');
    Route::get('/filter-sales', [ReportController::class, 'filterSales']);
    Route::get('/sales/return/report', [ReportController::class, 'salesRetrunReport'])->name('sales.return.report');

    Route::get('/product/stock/report', [ReportController::class, 'productStockReport'])->name('product.stock.report');


    Route::resource('role', RoleController::class);
    Route::get('role-datatable', [RoleController::class, 'roleDatatable'])->name('role-datatable');

    Route::resource('permission', PermissionController::class);
    Route::get('permission-datatable', [PermissionController::class, 'permissionDatatable'])->name('permission-datatable');


    Route::get('all/roles/permission', [RoleHasPermissionController::class, 'allRolesPermission'])->name('all.roles.permission');
    Route::get('add/roles/permission', [RoleHasPermissionController::class, 'addRolesPermission'])->name('add.roles.permission');
    Route::post('roles/permission/store', [RoleHasPermissionController::class, 'rolePermissionStore'])->name('role.permission.store');
    Route::get('/admin/edit/roles/{id}', [RoleHasPermissionController::class, 'adminEditRoles'])->name('edit.roles.permission');
    Route::post('/admin/update/roles/{id}', [RoleHasPermissionController::class, 'adminUpdateRoles'])->name('role.permission.update');
    Route::post('/admin/delete/roles/{id}', [RoleHasPermissionController::class, 'adminDeleteRole'])->name('role.permission.delete');
    Route::get('/role-permission-datatable', [RoleHasPermissionController::class, 'rolePermissionDatatable'])->name('role-permission-datatable');

    Route::get('all/admin', [RoleHasPermissionController::class, 'allAdmin'])->name('all.admin');
    Route::get('/all-admin-datatable', [RoleHasPermissionController::class, 'allAdminDatatable'])->name('all-admin-datatable');
    Route::get('add/admin', [RoleHasPermissionController::class, 'addAdmin'])->name('add.admin');
    Route::post('/store/admin', [RoleHasPermissionController::class, 'storeAdmin'])->name('admin.store');
    Route::get('/edit/admin/{id}', [RoleHasPermissionController::class, 'editAdmin'])->name('admin.edit');
    Route::post('/update/admin/{id}', [RoleHasPermissionController::class, 'updateAdmin'])->name('admin.update');
    Route::post('/admin/delete/{id}', [RoleHasPermissionController::class, 'deleteAdmin'])->name('admin.delete');



});
