<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\ProductController;
use App\Http\Controllers\web\OrderController;
use App\Http\Controllers\web\CartController;
use App\Http\Controllers\web\RegisterController;
use App\Http\Controllers\web\AccountController;
use App\Http\Controllers\web\RazorpayPaymentController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TwoFactorAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as admin_product;
use App\Http\Controllers\Admin\CommonSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ReviewController;

use App\Http\Controllers\ImageController;
// use Intervention\Image\Facades\Image;

// Route::get('/test-image', function () { 
//     $img = Image::canvas(300, 100, '#0000ff');
//     $img->save(public_path('blue-bar.jpg'));
//     return 'Blue image saved to public/blue-bar.jpg';
// });

Route::get('test', function () {
    return view('web.slider_oldindex');
});

Route::get('about', function () {
    return view('web.pages.about');
});
Route::get('terms-and-conditions', function () {
    return view('web.pages.terms-and-conditions');
});
Route::get('shipping-delivery-policy', function () {
    return view('web.pages.shipping-delivery-policy');
});
Route::get('cancellation-refund-policy', function () {
    return view('web.pages.cancellation-refund-policy');
});
Route::get('contact-us', function () {
    return view('web.pages.contact-us');
});
Route::get('privacypolicy', function () {
    return view('web.pages.privacypolicy');
});

    Route::controller(ProductController::class)->group(function () {

        Route::get('/','home_page')->name('home');
        Route::get('new','new')->name('');
        Route::get('more-products','more_product')->name('product.more');
        Route::get('product/show/{id}','details_page')->name('product.show');
    });   

    Route::middleware(['auth'])->group(function () {

        Route::controller(CartController::class)->group(function () {

            Route::get('addCart/{id}','addToCart')->name('cart.add');
            Route::get('product/cart','showCart')->name('cart.index');
            Route::delete('/cart/{id}','removeItem')->name('cart.remove');
            Route::post('cart/update', 'updateCart')->name('cart.update');
        });

        Route::controller(OrderController::class)->group(function () { 
            Route::get('addOrderSingle/{id}','addOrderSingle')->name('order.add');
            Route::get('addOrder','addOrder')->name('order.add');
            Route::post('place/order','placeOrder')->name('order.place');
            // Route::post('place/order','checkout')->name('order.place');
            Route::get('orders/history', 'orderHistory')->name('orders.history');  // order page 

            Route::get('track', 'track')->name('track');  // order page 
        });

        Route::controller(AccountController::class)->group(function () {
            Route::get('user/dashboard','dashboard')->name('user.dashboard');
            Route::post('update/account','update_account')->name('update.account');
            Route::get('/logout', 'logout')->name('user.logout');
        });
    });

    Route::controller(RegisterController::class)->group(function () {
   
        Route::get('sign-in', function () {
            return view('web.sign-in');
        })->name('sign-in');

        Route::post('/register', 'register')->name('user.register');
        Route::post('user/login', 'login')->name('user.login');
    });
    
Route::get('razorpay-payment', [RazorpayPaymentController::class, 'index']);
Route::post('razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');

// ****************************************** ADMIN ROUTES ************************************************* //
Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['admin']], function() {
        Route::get('2fa/setup', [TwoFactorAuthController::class, 'show2faForm'])->name('2fa.form');
        Route::post('2fa/setup', [TwoFactorAuthController::class, 'setup2fa'])->name('2fa.setup');
        Route::get('2fa/verify', [TwoFactorAuthController::class, 'showVerifyForm'])->name('2fa.verifyForm');
        Route::post('2fa/verify', [TwoFactorAuthController::class, 'verify2fa'])->name('2fa.verify');
    });

    // Optional: Also prefix login routes if admin login is separate
    Route::get('login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

    // Route::middleware(['2fa','session.timeout','admin'])->group(function () {

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('account_setting', [AuthController::class, 'account_setting'])->name('account_setting');
        Route::post('account_setting_change', [AuthController::class, 'account_setting_change'])->name('post.account_setting');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::resource('products', admin_product::class);
        Route::post('admin/products/delete/{id}', [admin_product::class, 'destroy_products'])->name('products.delete');
        Route::post('/products/image/{id}', [admin_product::class, 'removeImage'])->name('products.image.delete');
        Route::get('get-subcategories/{cat_id}', [admin_product::class, 'getSubcategories'])->name('product.sub-cate');

        Route::resource('users', UserController::class);
        Route::get('get_order_list', [UserController::class, 'get_order_list'])->name('get_order_list');
        Route::post('change_order_status', [UserController::class, 'change_order_status'])->name('change_order_status');
        // Route::post('/admin/order/update-status', [OrderController::class, 'updateStatus']);
        
        Route::get('get_setting', [CommonSettingController::class, 'get_setting'])->name('get_setting');
        Route::post('change_setting', [CommonSettingController::class, 'change_setting'])->name('change_setting');

        Route::resource('categories', CategoryController::class);
        Route::post('categories/delete/{id}', [CategoryController::class, 'destroy_categories'])->name('categories.delete');

        Route::resource('sub_categories', SubCategoryController::class);
        Route::post('sub_categories/delete/{id}', [SubCategoryController::class, 'destroy_sub_categories'])->name('sub_categories.delete');
       
        Route::resource('brands', BrandController::class);
        Route::post('brands/delete/{id}', [BrandController::class, 'destroy_brands'])->name('brands.delete');
       
        Route::resource('attributes', AttributeController::class);
        Route::post('attributes/delete/{id}', [AttributeController::class, 'destroy_attributes'])->name('attributes.delete');

        Route::resource('reviews', ReviewController::class);
    // });
});

Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');