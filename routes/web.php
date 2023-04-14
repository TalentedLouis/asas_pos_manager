<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigRegiController;
use App\Http\Controllers\EntryExitTargetController;
use App\Http\Controllers\ConfigTaxController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MakerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExitStockController;
use App\Http\Controllers\EntryStockController;
use App\Http\Controllers\ExitMoneyController;
use App\Http\Controllers\EntryMoneyController;
use App\Http\Controllers\ReceiptConfigController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShopConfigController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SupplierTargetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DailyRenewalController;
use App\Http\Controllers\StockTakingController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resources([
        'shop' => ShopController::class,
        'supplier_target' => SupplierTargetController::class,
        'category' => CategoryController::class,
        'genre' => GenreController::class,
        'maker' => MakerController::class,
        'customer' => CustomerController::class,
        'user' => UserController::class,
        'entry_exit_target' => EntryExitTargetController::class,
        'config_tax' => ConfigTaxController::class,
        'plan' => PlanController::class,
        'type' => TypeController::class,
        'config_regi' => ConfigRegiController::class,
        'staff' => StaffController::class,
        'room' => RoomController::class,
        'receipt_config' => ReceiptConfigController::class,
        'shop_config' => ShopConfigController::class,
        'daily_renewal' => DailyRenewalController::class,
        'stock_taking' => StockTakingController::class
    ]);
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/report/search', [ReportController::class, 'search'])->name('report.search');
    Route::get('/report/download_excel', [ReportController::class, 'download_excel'])->name('report.download_excel');
    
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::match(['PUT', 'PATCH'], '/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/code_search', [ProductController::class, 'code_search'])->name('product.code_search');
    Route::post('/product/name_search', [ProductController::class, 'name_search'])->name('product.name_search');
    Route::post('/product/name_search_result', [ProductController::class, 'name_search_result'])->name('product.name_search_result');
    Route::get('/product/code_create', [ProductController::class, 'code_create'])->name('product.code_create');

    Route::post('/customer/code_search', [CustomerController::class, 'code_search'])->name('customer.code_search');
    Route::post('/customer/name_search', [CustomerController::class, 'name_search'])->name('customer.name_search');

    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{slip}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::match(['PUT', 'PATCH'], '/purchase/{slip}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{slip}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    Route::post('/purchase/search', [PurchaseController::class, 'search'])->name('purchase.search');

    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sale/create', [SaleController::class, 'create'])->name('sale.create');
    Route::post('/sale', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/sale/{slip}/edit', [SaleController::class, 'edit'])->name('sale.edit');
    Route::match(['PUT', 'PATCH'], '/sale/{slip}', [SaleController::class, 'update'])->name('sale.update');
    Route::delete('/sale/{slip}', [SaleController::class, 'destroy'])->name('sale.destroy');
    Route::post('/sale/search', [SaleController::class, 'search'])->name('sale.search');

    Route::get('/exit_stock', [ExitStockController::class, 'index'])->name('exit_stock.index');
    Route::get('/exit_stock/create', [ExitStockController::class, 'create'])->name('exit_stock.create');
    Route::post('/exit_stock', [ExitStockController::class, 'store'])->name('exit_stock.store');
    Route::get('/exit_stock/{slip}/edit', [ExitStockController::class, 'edit'])->name('exit_stock.edit');
    Route::match(['PUT', 'PATCH'], '/exit_stock/{slip}', [ExitStockController::class, 'update'])->name('exit_stock.update');
    Route::delete('/exit_stock/{slip}', [ExitStockController::class, 'destroy'])->name('exit_stock.destroy');
    Route::post('/exit_stock/search', [ExitStockController::class, 'search'])->name('exit_stock.search');

    Route::get('/entry_stock', [EntryStockController::class, 'index'])->name('entry_stock.index');
    Route::get('/entry_stock/create', [EntryStockController::class, 'create'])->name('entry_stock.create');
    Route::post('/entry_stock', [EntryStockController::class, 'store'])->name('entry_stock.store');
    Route::get('/entry_stock/{slip}/edit', [EntryStockController::class, 'edit'])->name('entry_stock.edit');
    Route::match(['PUT', 'PATCH'], '/entry_stock/{slip}', [EntryStockController::class, 'update'])->name('entry_stock.update');
    Route::delete('/entry_stock/{slip}', [EntryStockController::class, 'destroy'])->name('entry_stock.destroy');
    Route::post('/entry_stock/search', [EntryStockController::class, 'search'])->name('entry_stock.search');

    Route::get('/exit_money', [ExitMoneyController::class, 'index'])->name('exit_money.index');
    Route::get('/exit_money/create', [ExitMoneyController::class, 'create'])->name('exit_money.create');
    Route::post('/exit_money', [ExitMoneyController::class, 'store'])->name('exit_money.store');
    Route::get('/exit_money/{slip}/edit', [ExitMoneyController::class, 'edit'])->name('exit_money.edit');
    Route::match(['PUT', 'PATCH'], '/exit_money/{slip}', [ExitMoneyController::class, 'update'])->name('exit_money.update');
    Route::delete('/exit_money/{slip}', [ExitMoneyController::class, 'destroy'])->name('exit_money.destroy');
    Route::post('/exit_money/search', [ExitMoneyController::class, 'search'])->name('exit_money.search');

    Route::get('/entry_money', [EntryMoneyController::class, 'index'])->name('entry_money.index');
    Route::get('/entry_money/create', [EntryMoneyController::class, 'create'])->name('entry_money.create');
    Route::post('/entry_money', [EntryMoneyController::class, 'store'])->name('entry_money.store');
    Route::get('/entry_money/{slip}/edit', [EntryMoneyController::class, 'edit'])->name('entry_money.edit');
    Route::match(['PUT', 'PATCH'], '/entry_money/{slip}', [EntryMoneyController::class, 'update'])->name('entry_money.update');
    Route::delete('/entry_money/{slip}', [EntryMoneyController::class, 'destroy'])->name('entry_money.destroy');
    Route::post('/entry_money/search', [EntryMoneyController::class, 'search'])->name('entry_money.search');

    Route::get('/stock_taking/{product?}/edit', [StockTakingController::class, 'edit'])->name('stock_taking.edit');
    Route::post('/stock_taking/code_search', [StockTakingController::class, 'code_search'])->name('stock_taking.code_search');
    Route::match(['PUT', 'PATCH'], '/stock_taking/{product}', [StockTakingController::class, 'update'])->name('stock_taking.update');
    Route::get('/stock_taking', [StockTakingController::class, 'index'])->name('stock_taking.index');
    Route::get('/stock_taking/select', [StockTakingController::class, 'select'])->name('stock_taking.select');
});
require __DIR__ . '/auth.php';
