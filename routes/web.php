<?php

use App\Http\Livewire\ActivityLog\ActivityLogTable;
use App\Http\Livewire\AdminPanel\Extras\PaymentCategoryTable;
use App\Http\Livewire\AdminPanel\Inventory\InventoryTable;
use App\Http\Livewire\AdminPanel\ManageAccounts\AdminTable;
use App\Http\Livewire\AdminPanel\ManageAccounts\CashierTable;
use App\Http\Livewire\AdminPanel\ManageClient\StudentTable;
use App\Http\Livewire\AdminPanel\ManageReport\DailyReportTable;
use App\Http\Livewire\AdminPanel\ManageReport\ManageReportTable;
use App\Http\Livewire\AdminPanel\ManageServices\ModeOfPaymentTable;
use App\Http\Livewire\AdminPanel\ManageServices\PaymentDetailTable;
use App\Http\Livewire\AdminPanel\ProductCategory\ProductCategoryTable;
use App\Http\Livewire\AdminPanel\PurchaseProduct\PurchaseProductTable;
use App\Http\Livewire\AdminPanel\Sale\SaleTable;
use App\Http\Livewire\CashierPanel\Sales\DaySalesTable;
use App\Http\Livewire\CashierPanel\Sales\SalesTable;
use App\Http\Livewire\CashierPanel\Transaction\TransactionTable;
use App\Http\Livewire\CashierPanel\TransactionHistory\TransactionHistoryTable;
use App\Http\Livewire\DashBoard\DashBoard;
use App\Http\Livewire\Profile\EditProfileForm;
use App\Http\Livewire\Profile\PasswordUpdate;
use App\Http\Livewire\QueueingSystem\QueueingDisplay;
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
    // return view('welcome');
    return redirect()->route('login');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    
    Route::get('/dashboard', DashBoard::class)->name('dashboard');
    Route::get('/editprofileform', EditProfileForm::class)->name('editprofileform');
    Route::get('/passwordupdate', PasswordUpdate::class)->name('passwordupdate');
    
    
    // Admin Panel
    Route::get('/admin-table', AdminTable::class)->name('admin-table')->middleware('checkRulepermissionadmin');
    Route::get('/product-category-table', ProductCategoryTable::class)->name('product-category-table')->middleware('checkRulepermissionadmin');
    Route::get('/inventory-table', InventoryTable::class)->name('inventory-table')->middleware('checkRulepermissionadmin');
    Route::get('/purchase-product-table', PurchaseProductTable::class)->name('purchase-product-table')->middleware('checkRulepermissionadmin');
    Route::get('/sale-table', SaleTable::class)->name('sale-table')->middleware('checkRulepermissionadmin');
});
