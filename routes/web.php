<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectInactiveUser;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Frontend\WishlistproductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ProfileCustomerController;
use App\Http\Controllers\Frontend\SingleproductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\TrackingController;
use App\Http\Controllers\Frontend\DeliveryProductController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\PaymentReportController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorPurchaseController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\CustomerChatController;
use App\Http\Controllers\TransactionController;


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

// Route register customer
Route::get('/customer/register', [CustomerRegisterController::class, 'showRegistrationForm'])->name('customer.register');
Route::post('/customer/register', [CustomerRegisterController::class, 'register'])->name('customer.register.post');

// Route login customer
Route::get('/customer/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerLoginController::class, 'login'])->name('customer.login.post');


// Route untuk Admin Page
Route::group(['middleware' => 'auth'], function () {
    Route::resource('profile-admin', \App\Http\Controllers\Admin\ProfileAdminController::class);
    Route::get('/profile/admin', [ProfileAdminController::class, 'index'])->name('admin.profile');
    Route::post('/admin/update-profile', [ProfileAdminController::class, 'update'])->name('admin.update-profile');

    Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class);
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/monthly-data', [DashboardController::class, 'monthlyData'])->name('admin.dashboard.monthlyData');

    Route::resource('product-category', \App\Http\Controllers\Admin\ProductCategoryController::class);
    Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('product-review', \App\Http\Controllers\Admin\ProductReviewController::class);
    Route::resource('wishlist', \App\Http\Controllers\Admin\WishlistController::class);
    Route::resource('discount-category', \App\Http\Controllers\Admin\DiscountCategoryController::class);
    Route::resource('discount', \App\Http\Controllers\Admin\DiscountController::class);
    Route::resource('order-detail', \App\Http\Controllers\Admin\OrderDetailController::class);
    Route::resource('delivery', \App\Http\Controllers\Admin\DeliveryController::class);

    Route::resource('order', \App\Http\Controllers\Admin\OrderController::class);
    Route::post('/order/deliver/{id}', [OrderController::class, 'deliverOrder'])->name('order.deliver');

    Route::resource('payment', \App\Http\Controllers\Admin\PaymentController::class);

    Route::get('/user/add-role', [UserController::class, 'addRoleForm'])->name('user.addRoleForm');
    Route::post('/user/add-role', [UserController::class, 'addRole'])->name('user.addRole');

    Route::get('/admin/vendor', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/admin/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/admin/vendor', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/admin/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/admin/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendors/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');

    Route::get('/admin/vendor/purchases', [VendorPurchaseController::class, 'index'])->name('vendor.purchase.index');
    Route::get('/admin/vendor/purchase', [VendorPurchaseController::class, 'purchaseForm'])->name('vendor.purchase.form');
    Route::post('/admin/vendor/purchase', [VendorPurchaseController::class, 'purchase'])->name('vendor.purchase');
    Route::get('/admin/vendor/purchases/{id}/edit', [VendorPurchaseController::class, 'edit'])->name('vendor.purchase.edit');
    Route::put('/admin/vendor/purchases/{id}', [VendorPurchaseController::class, 'update'])->name('vendor.purchase.update');
    Route::delete('/admin/vendor/purchase/{id}', [VendorPurchaseController::class, 'destroy'])->name('vendor.purchase.destroy');

    Route::get('/customer-chat', [CustomerChatController::class, 'index'])->name('customer-chat.index');


    Route::middleware('check.role')->group(function () {
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('customer', \App\Http\Controllers\Admin\CustomerController::class);
        Route::get('/payment-report', [PaymentReportController::class, 'index'])->name('payment.report');
        Route::get('/payment-report/pdf', [PaymentReportController::class, 'exportPdf'])->name('payment.report.pdf');
        Route::get('/payment-report/excel', [PaymentReportController::class, 'exportExcel'])->name('payment.report.excel');
        
     });
});

// Route Autentikasi 
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route Frontend untuk Customer 
Route::group(['middleware' => 'auth:customers'], function () {

    Route::resource('home', \App\Http\Controllers\Frontend\LandingpageController::class);

    Route::resource('cart', \App\Http\Controllers\Frontend\CartController::class);
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/proceed-all-to-cart', [CartController::class, 'proceedAllToCart'])->name('proceed-all-to-cart');
    Route::get('/cart', [CartController::class, 'showCart'])->name('show-cart');
    Route::post('/cart/delete/{id}', [CartController::class, 'deleteFromCart'])->name('cart.delete');
    Route::post('/add-to-cart-from-wishlist/{wishlistProduct}', [CartController::class, 'addToCartFromWishlist'])->name('add-to-cart-from-wishlist');
    Route::post('/update-cart-quantity/{id}', [CartController::class, 'updateCartQuantity']);
    Route::get('/add-to-cart/{productId}/{price}', [\App\Http\Controllers\Frontend\CartController::class, 'addToCart'])->name('cart.add');

    Route::resource('checkout', \App\Http\Controllers\Frontend\CheckoutController::class);
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.get');
    Route::get('/proceed-to-checkout', [CheckoutController::class, 'proceedToCheckout'])->name('proceed-to-checkout');
    Route::post('/checkout/update-status/{id}', [CheckoutController::class, 'updateOrderStatus'])->name('checkout.updateStatus');
    Route::post('/checkout/create-payment', [CheckoutController::class, 'createPayment'])->name('checkout.create-payment');
    Route::post('/checkout/create-delivery', [CheckoutController::class, 'createDeliveryRecord']);
    Route::post('/checkout/update-order-delivery-status/{id}', [CheckoutController::class, 'updateOrderAndDeliveryStatus']);
    Route::post('/calculate-shipping-cost', [CheckoutController::class, 'calculateShippingCost'])->name('calculate.shipping.cost');

    Route::get('/search', 'App\Http\Controllers\Frontend\CategoryController@search')->name('category.search');

    Route::resource('category', \App\Http\Controllers\Frontend\CategoryController::class);

    Route::resource('contact', \App\Http\Controllers\Frontend\ContactController::class);
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::resource('single-product', \App\Http\Controllers\Frontend\SingleproductController::class);
    Route::post('product/{id}/submit-review', '\App\Http\Controllers\Frontend\SingleproductController@submitReview')->name('submit_review');
    Route::delete('/product/review/{id}', [SingleproductController::class, 'deleteReview'])->name('delete_review');

    Route::resource('tracking', \App\Http\Controllers\Frontend\TrackingController::class); 
    Route::get('/tracking',[TrackingController::class, 'index']);
    Route::post('/tracking', [TrackingController::class, 'cekOngkir']);

    Route::resource('delivery-product', \App\Http\Controllers\Frontend\DeliveryProductController::class); 
    Route::get('/delivery-product', [DeliveryProductController::class, 'index'])->name('delivery.product.index');
    Route::post('/profile/receive-package', [DeliveryProductController::class, 'receivePackage'])->name('profile.receive-package');
    Route::post('/cancel-order/{orderId}', [DeliveryProductController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/delete-order-history/{deliveryId}', [DeliveryProductController::class, 'deleteOrderHistory'])->name('delivery.delete-history');
    Route::get('/update-delivery-status', [DeliveryProductController::class, 'updateDeliveryStatus']);

    Route::resource('wishlist-product', WishlistproductController::class);
    Route::post('/add-to-wishlist', [WishlistproductController::class, 'addToWishlist'])->name('wishlist-product.add');
    Route::get('/wishlist-product/count', [WishlistproductController::class, 'index'])->name('wishlist-product.count');

    Route::resource('/profile/customer', \App\Http\Controllers\Frontend\ProfileCustomerController::class);
    Route::get('/customer/profile', [ProfileCustomerController::class, 'index'])->name('customer.profile');
    Route::post('/customer/profile/update', [ProfileCustomerController::class, 'update'])->name('customer.update-profile');
    Route::post('/profile/picture/update', [ProfileCustomerController::class, 'updateProfilePicture'])->name('profile.picture.update');

});

Route::resource('/', \App\Http\Controllers\Frontend\LandingpageController::class);


