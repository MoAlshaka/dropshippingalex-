<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Seller\LeadController;
use App\Http\Controllers\Seller\ErrorController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\Auth\AuthController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ImportProductController;
use App\Http\Controllers\Seller\SharedProductController;
use App\Http\Controllers\Seller\AffiliateProductController;
use App\Http\Controllers\Seller\TransactionController;
use App\Http\Controllers\Seller\OrderController;

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

define('PAGINATION_COUNT', 30);
Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/seller',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest:seller']
], function () {
    Route::get('/register', [AuthController::class, 'get_seller_register'])->name('get.seller.register');
    Route::post('register', [AuthController::class, 'register'])->name('seller.register');
    Route::get('/login', [AuthController::class, 'get_seller_login'])->name('get.seller.login');
    Route::post('login', [AuthController::class, 'login'])->name('seller.login');
});
Route::group([
    //    'namespace' => 'Admin',
    'prefix' => LaravelLocalization::setLocale() . '/seller',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:seller']
], function () {
    Route::get('active-page', [AuthController::class, 'deactivate'])->name('seller.deactivate');
    Route::middleware(['is_active'])->group(function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('seller.dashboard');
        //sharedproducts
        Route::get('shared-products', [SharedProductController::class, 'index'])->name('seller.sharedproducts.index');
        Route::get('shared-product/{id}', [SharedProductController::class, 'show'])->name('seller.sharedproduct.show');
        Route::post('import-shared-product/{id}', [SharedProductController::class, 'import'])->name('seller.sharedproduct.import');
        Route::post('exclude-shared-product/{id}', [SharedProductController::class, 'exclude'])->name('seller.sharedproduct.exclude');
        Route::get('/shared-products/filter/{country}', [SharedProductController::class, 'country_filter'])->name('shared.country.filter');
        Route::get('/shared-products/new-products', [SharedProductController::class, 'new_product'])->name('new.shared.product');
        Route::get('/shared-products/suggested-products', [SharedProductController::class, 'suggested_product'])->name('suggested.shared.product');
        Route::post('/shared-products/search', [SharedProductController::class, 'search'])->name('search.shared.product');
        //Affiliateproducts
        Route::get('affiliate-products', [AffiliateProductController::class, 'index'])->name('seller.affiliateproducts.index');
        Route::get('affiliate-product/{id}', [AffiliateProductController::class, 'show'])->name('seller.affiliateproduct.show');
        Route::post('import-affiliate-product/{id}', [AffiliateProductController::class, 'import'])->name('seller.affiliateproduct.import');
        Route::post('exclude-affiliate-product/{id}', [AffiliateProductController::class, 'exclude'])->name('seller.affiliateproduct.exclude');
        Route::get('/affiliate-products/filter/{country}', [AffiliateProductController::class, 'country_filter'])->name('affiliate.country.filter');
        Route::get('/affiliate-products/new-products', [AffiliateProductController::class, 'new_product'])->name('new.affiliate.product');
        Route::get('/affiliate-products/suggested-products', [AffiliateProductController::class, 'suggested_product'])->name('suggested.affiliate.product');
        Route::post('/affiliate-products/search', [AffiliateProductController::class, 'search'])->name('search.affiliate.product');
        //imported product
        Route::get('import-products', [ImportProductController::class, 'imported_products'])->name('seller.products.imported');
        //leads
        Route::resource('leads', LeadController::class);
        Route::post('lead/search', [LeadController::class, 'search'])->name('seller.leads.search');
        Route::post('lead/filter', [LeadController::class, 'filter'])->name('seller.leads.filter');
        // profile
        Route::get('profile', [ProfileController::class, 'index'])->name('seller.profile');
        Route::match(['post', 'put', 'patch'], 'profile/update/{id}', [ProfileController::class, 'update_profile'])->name('seller.update.profile');
        Route::get('edit-password', [ProfileController::class, 'edit_password'])->name('seller.edit.password');
        Route::match(['post', 'put', 'patch'], 'update-password/{id}', [ProfileController::class, 'change_password'])->name('seller.change.password');
        Route::match(['post', 'put', 'patch'], 'payment-details/update/{id}', [ProfileController::class, 'payment_details'])->name('seller.update.payment');

        //transaction
        Route::get('transactions', [TransactionController::class, 'index'])->name('seller.transactions.index');
        Route::get('notification/{id}', [TransactionController::class, 'notification'])->name('seller.notification');
        Route::get('notifications/read-all', [TransactionController::class, 'read_all'])->name('seller.notification.read.all');
        //orders
        Route::get('orders', [OrderController::class, 'index'])->name('seller.orders.index');
        Route::get('orders/show/{id}', [OrderController::class, 'show'])->name('seller.orders.show');
        Route::post('orders/filter', [OrderController::class, 'filter'])->name('seller.orders.filter');


        // error
        Route::fallback([ErrorController::class, 'error'])->name('admin.error');

    });
    Route::get('logout', [AuthController::class, 'logout'])->name('seller.logout');

});
