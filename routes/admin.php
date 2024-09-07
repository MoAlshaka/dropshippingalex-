<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ActiveSellerController;
use App\Http\Controllers\Admin\SharedProductController;
use App\Http\Controllers\Admin\AffiliateProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

define('COUNT', 30);
Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:admin']
], function () {
    Route::get('/login', [AuthController::class, 'get_admin_login'])->name('get.admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login');
});
Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:admin']
], function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/', [DashboardController::class, 'filter'])->name('admin.dashboard.filter');
    //Categories
    Route::resource('categories', CategoryController::class);
    //payment_methods
    //    Route::resource('payments', PaymentController::class);
    //Countries
    Route::resource('countries', CountryController::class);
    //offers
    Route::resource('offers', OfferController::class);
    //transactions
    Route::resource('transactions', TransactionController::class);
    Route::get('transaction/seller/{id}', [TransactionController::class, 'get_seller_info'])->name('admin.seller.info');
    Route::post('transaction/filter', [TransactionController::class, 'filter'])->name('admin.transaction.filter');

    // products
    Route::resource('shared-products', SharedProductController::class);
    Route::match(['post', 'put', 'patch'], 'shared-products/{id}', [SharedProductController::class, 'update'])->name('admin.sharedproducts.update');
    Route::get('/shared-product/new-products', [SharedProductController::class, 'new_product'])->name('admin.new.shared.product');
    Route::get('/shared-product/suggested-products', [SharedProductController::class, 'suggested_product'])->name('admin.suggested.shared.product');
    Route::post('/shared-product/search', [SharedProductController::class, 'search'])->name('admin.search.shared.product');

    //
    Route::resource('affiliate-products', AffiliateProductController::class);
    Route::get('affiliate-per-delivered', [AffiliateProductController::class, 'per_delivered'])->name('admin.affiliate.per.delivered');
    Route::get('affiliate-per-confirmed', [AffiliateProductController::class, 'per_confirmed'])->name('admin.affiliate.per.confirmed');
    Route::match(['post', 'put', 'patch'], 'affiliate-products/{id}', [AffiliateProductController::class, 'update'])->name('admin.affiliateproducts.update');
    Route::get('/affiliate-per-delivered/new-products', [AffiliateProductController::class, 'new_product_per_delivered'])->name('admin.new.affiliate.per.delivered');
    Route::get('/affiliate-per-delivered/suggested-products', [AffiliateProductController::class, 'suggested_product_per_delivered'])->name('admin.suggested.affiliate.per.delivered');
    Route::post('/affiliate-per-delivered/search', [AffiliateProductController::class, 'search_per_delivered'])->name('admin.search.affiliate.per.delivered');
    Route::get('/affiliate-per-confirmed/new-products', [AffiliateProductController::class, 'new_product_per_confirmed'])->name('admin.new.affiliate.per.confirmed');
    Route::get('/affiliate-per-confirmed/suggested-products', [AffiliateProductController::class, 'suggested_product_per_confirmed'])->name('admin.suggested.affiliate.per.confirmed');
    Route::post('/affiliate-per-confirmed/search', [AffiliateProductController::class, 'search_per_confirmed'])->name('admin.search.affiliate.per.confirmed');

    //
    Route::get('filter/shared-products/{country}', [SharedProductController::class, 'country_filter'])->name('admin.shared.country.filter');
    Route::get('filter/affiliate-per-delivered/{country}', [AffiliateProductController::class, 'country_filter_per_delivered'])->name('admin.affiliate.per.delivered.country.filter');
    Route::get('filter/affiliate-per-confirmed/{country}', [AffiliateProductController::class, 'country_filter_per_confirmed'])->name('admin.affiliate.per.confirmed.country.filter');
    //Seller
    Route::get('sellers', [ActiveSellerController::class, 'index'])->name('admin.sellers.index');
    Route::get('seller/show/{id}', [ActiveSellerController::class, 'show'])->name('admin.sellers.show');
    Route::post('seller/add-manager/{id}', [ActiveSellerController::class, 'add_manager'])->name('admin.sellers.add.manager');
    Route::match(['post', 'put', 'patch'], 'seller/remove-manager/{id}', [ActiveSellerController::class, 'remove_manager'])->name('admin.sellers.remove.manager');
    Route::match(['post', 'put', 'patch'], 'active-sellers/{id}', [ActiveSellerController::class, 'active'])->name('admin.sellers.active');
    Route::delete('sellers/delete/{id}', [ActiveSellerController::class, 'delete'])->name('admin.sellers.delete');
    //Leads
    Route::get('leads', [LeadController::class, 'index'])->name('admin.leads.index');
    Route::get('leads/edit/{id}', [LeadController::class, 'edit'])->name('admin.leads.edit');
    Route::match(['post', 'put', 'patch'], 'leads/update/{id}', [LeadController::class, 'update'])->name('admin.leads.update');
    Route::post('leads/delete/{id}', [LeadController::class, 'delete'])->name('admin.leads.delete');
    Route::get('lead/show/{id}', [LeadController::class, 'show'])->name('admin.lead.show');
    Route::post('lead/search', [LeadController::class, 'search'])->name('admin.leads.search');
    Route::post('lead/filter', [LeadController::class, 'filter'])->name('admin.leads.filter');
    Route::get('lead/export-leads', [LeadController::class, 'export'])->name('export.leads');


    // orders
    Route::resource('orders', OrderController::class);
    Route::post('orders/search', [OrderController::class, 'search'])->name('admin.orders.search');
    Route::post('orders/filter', [OrderController::class, 'filter'])->name('admin.orders.filter');
    //Reports
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('filter/report/country/{country}', [ReportController::class, 'filter_country'])->name('admin.report.country.filter');
    Route::post('reports/filter/{id}', [ReportController::class, 'filter'])->name('admin.reports.filter');
    Route::get('reports/affiliate-filter', [ReportController::class, 'affiliate_filter'])->name('admin.reports.affiliate.filter');
    Route::post('reports/affiliate/filter', [ReportController::class, 'affiliate_filter_date'])->name('admin.reports.affiliate.filter.date');
    Route::get('reports/marketplace', [ReportController::class, 'marketplace'])->name('admin.reports.marketplace.filter');
    Route::post('reports/marketplace/filter', [ReportController::class, 'markplace_filter_date'])->name('admin.reports.marketplace.filter.date');
    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);


    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/filter', [InvoiceController::class, 'filter'])->name('admin.invoices.filter');

    //profile
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::match(['post', 'put', 'patch'], 'profile/update/{id}', [ProfileController::class, 'update_profile'])->name('admin.update.profile');
    Route::get('edit-password', [ProfileController::class, 'edit_password'])->name('admin.edit.password');
    Route::match(['post', 'put', 'patch'], 'update-password/{id}', [ProfileController::class, 'change_password'])->name('admin.change.password');


    //logout
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::fallback([ErrorController::class, 'error'])->name('admin.error');
});
