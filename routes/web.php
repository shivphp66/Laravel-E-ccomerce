<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ChangePasswordController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\TestController;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/test', function () {
    return orderEmail(16);
});*/

Route::get('/', [FrontController::class,'index'])->name('front.home');

Route::get('/shop/{categorySlub?}/{subcategorySlug?}', [ShopController::class,'index'])->name('front.shop');
Route::get('/product/{slug}', [ShopController::class,'product'])->name('front.product');

Route::get('/cart', [CartController::class,'cart'])->name('front.cart');
Route::post('/add-to-cart', [CartController::class,'addToCart'])->name('front.addToCart');
Route::post('/update-cart', [CartController::class,'updateCart'])->name('front.updateCart');
Route::post('/delete-cart-item', [CartController::class,'deleteItem'])->name('front.deleteItem');
Route::get('/checkout', [CartController::class,'checkout'])->name('front.checkout');
Route::post('/process-checkout', [CartController::class,'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}', [CartController::class,'thankyou'])->name('front.thankyou');
Route::post('/get-order-summery', [CartController::class,'getOrderSummery'])->name('front.getOrderSummery');
Route::post('/apply-discount', [CartController::class,'applyDiscount'])->name('front.applyDiscount');
Route::post('/remove-discount', [CartController::class,'removeCoupen'])->name('front.removeCoupen');
Route::post('/add-to-wishlist', [FrontController::class,'addToWishlist'])->name('front.addToWishlist');
Route::get('/pages/{slug}', [FrontController::class,'page'])->name('front.page');
Route::post('/send/contact/email', [FrontController::class,'sendContactEmail'])->name('front.sendContactEmail');

Route::get('/forgot/password', [AuthController::class,'forGotPassword'])->name('account.forGotPassword');
Route::post('/reset/password', [AuthController::class,'resetPassword'])->name('account.resetPassword');
Route::get('/process/reset/password/{token}', [AuthController::class,'processResetPassword'])->name('account.processResetPassword');
Route::post('/do/process/reset/password/', [AuthController::class,'doProcessResetPassword'])->name('account.doProcessResetPassword');
Route::post('/save-rating/{pid}', [ShopController::class,'saveProductRating'])->name('front.saveProductRating');

//contact Route//
Route::group(['prefix'=>'account'],function(){
    Route::group(['middleware'=>'guest'],function(){
        Route::get('/register', [AuthController::class,'register'])->name('account.register');
        Route::post('/save-register', [AuthController::class,'saveRegister'])->name('account.saveRegister');
        Route::get('/login', [AuthController::class,'login'])->name('account.login');
        Route::post('/login', [AuthController::class,'authenticate'])->name('account.authenticate');
  });

  Route::group(['middleware'=>'auth'],function(){
    Route::get('/profile', [AuthController::class,'profile'])->name('account.profile');
    Route::get('/logout', [AuthController::class,'logout'])->name('account.logout');
    Route::get('/my-orders', [AuthController::class,'orders'])->name('account.orders');
    Route::get('/order-detail/{orerId}', [AuthController::class,'orderDetail'])->name('account.orderDetail');
    Route::get('/wishlist', [AuthController::class,'wishlist'])->name('account.wishlist');
    Route::post('/remove-wishlist', [AuthController::class,'removeWishlist'])->name('account.removeWishlist');
    Route::post('/update-profile', [AuthController::class,'updateProfile'])->name('account.updateProfile');
    Route::post('/update-user-address', [AuthController::class,'updateUserAddress'])->name('account.updateUserAddress');
    Route::get('/change/password', [AuthController::class,'changePassword'])->name('account.changePassword');
    Route::post('/update/password', [AuthController::class,'updatePassword'])->name('account.updatePassword');
  });
});

//admin Route Bigning//
Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('/login', [AdminLoginController::class,'index'])->name('admin.login');
        Route::POST('/authenticate', [AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('/dashboard', [HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class,'logout'])->name('admin.logout');

        //category Route//

        Route::get('/categories/create', [CategoryController::class,'create'])->name('categories.create');
        Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
        Route::POST('/categories', [CategoryController::class,'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class,'edit'])->name('categories.edit');
        Route::PUT('/categories/{category}', [CategoryController::class,'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class,'destroy'])->name('categories.delete');

        //Subcategory Routes//

        Route::get('/sub-categories', [SubCategoryController::class,'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create', [SubCategoryController::class,'create'])->name('sub-categories.create');
        Route::POST('/sub-categories', [SubCategoryController::class,'store'])->name('sub-categories.store');
        Route::PUT('/sub-categories/{sub_category}', [SubCategoryController::class,'update'])->name('sub-categories.update');
        Route::get('/sub-categories/{sub_category}/edit', [SubCategoryController::class,'edit'])->name('sub-categories.edit');
        Route::delete('/sub-categories/{sub_category}', [SubCategoryController::class,'destroy'])->name('sub-categories.delete');

        //Brands Routes//

        Route::get('/brands', [BrandController::class,'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class,'create'])->name('brands.create');
        Route::POST('/brands', [BrandController::class,'store'])->name('brands.store');
        Route::PUT('/brands/{brands}', [BrandController::class,'update'])->name('brands.update');
        Route::get('/brands/{brands}/edit', [BrandController::class,'edit'])->name('brands.edit');
        Route::delete('/brands/{brands}', [BrandController::class,'destroy'])->name('brands.delete');

       //Products Routes//

       Route::get('/products', [ProductController::class,'index'])->name('products.index');
       Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
       Route::POST('/products', [ProductController::class,'store'])->name('products.store');
       Route::get('/products/{products}/edit', [ProductController::class,'edit'])->name('products.edit');
       Route::PUT('/products/{products}', [ProductController::class,'update'])->name('products.update');
       Route::get('/get-Products', [ProductController::class,'getProducts'])->name('products.getProducts');
       Route::delete('/products/{products}', [ProductController::class,'destroy'])->name('products.delete');
       Route::get('/products/ratings', [ProductController::class,'productRating'])->name('products.productRating');
       Route::get('/update/ratings', [ProductController::class,'updateProductRating'])->name('products.updateProductRating');

       Route::get('/products-subcategories', [ProductSubCategoryController::class,'index'])->name('products-subcategories.index');

       Route::post('/product-images/update', [ProductImageController::class,'update'])->name('product-images.update');
       Route::delete('/product-images', [ProductImageController::class,'destroy'])->name('product-images.destroy');
        //temp-images.create

        Route::post('/upload-temp-image', [TempImagesController::class,'create'])->name('temp-images.create');

        //shipping route//

        Route::get('/shipping-create', [ShippingController::class,'create'])->name('shipping.create');
        Route::post('/shipping', [ShippingController::class,'store'])->name('shpping.store');
        Route::get('/shipping/{id}', [ShippingController::class,'edit'])->name('shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class,'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class,'destroy'])->name('shipping.destroy');

        //coupon code route//

        Route::get('/coupons', [DiscountCodeController::class,'index'])->name('coupons.index');
        Route::get('/coupons/create', [DiscountCodeController::class,'create'])->name('coupon.create');
        Route::POST('/coupons', [DiscountCodeController::class,'store'])->name('coupons.store');
        Route::get('/coupons/{id}/edit', [DiscountCodeController::class,'edit'])->name('coupons.edit');
        Route::PUT('/coupons/{id}', [DiscountCodeController::class,'update'])->name('coupons.update');
        Route::delete('/coupons/{id}', [DiscountCodeController::class,'destroy'])->name('coupons.destroy');

        //Order route//

        Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
        Route::get('/orders/{orderId}', [OrderController::class,'details'])->name('orders.details');
        Route::PUT('/orders/{id}', [OrderController::class,'update'])->name('orders.update');
        Route::delete('/orders/{id}', [OrderController::class,'destroy'])->name('orders.destroy');
        Route::post('/orders/change-status/{oderId}', [OrderController::class,'chageOrderStatus'])->name('orders.chageOrderStatus');
        Route::post('/orders/send-email/{id}', [OrderController::class,'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');

    //users route//

        Route::get('/users', [UsersController::class,'index'])->name('users.index');
        Route::get('/users/create', [UsersController::class,'create'])->name('users.create');
        Route::POST('/users/add', [UsersController::class,'store'])->name('users.store');
        Route::get('/users/{id}', [UsersController::class,'update'])->name('users.update');
        Route::PUT('/users/{id}', [UsersController::class,'edit'])->name('users.edit');
        Route::delete('/users/{id}', [UsersController::class,'destroy'])->name('users.destroy');

        //Pages route//

        Route::get('/pages', [PageController::class,'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class,'create'])->name('pages.create');
        Route::POST('/pages/add', [PageController::class,'store'])->name('pages.store');
        Route::get('/pages/{id}', [PageController::class,'update'])->name('pages.update');
        Route::PUT('/pages/{id}', [PageController::class,'edit'])->name('pages.edit');
        Route::delete('/pages/{id}', [PageController::class,'destroy'])->name('pages.destroy');

        //Banner route//
        Route::get('/banners', [BannerController::class,'index'])->name('banners.index');
        Route::get('/banners/create', [BannerController::class,'create'])->name('banners.create');
        Route::post('/banners/store', [BannerController::class,'store'])->name('banners.store');
        Route::get('/banners/update/{bid}', [BannerController::class,'edit'])->name('banners.edit');
        Route::put('/banners/edit/{bid}', [BannerController::class,'update'])->name('banners.update');

        //Setting  Route//

        Route::get('/setting/change/password', [ChangePasswordController::class,'index'])->name('admin.showChangePassword');
        Route::post('/setting/update/password', [ChangePasswordController::class,'updatePassword'])->name('admin.updatePassword');

        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
                return response()->json([
                    'status'=>true,
                    'slug' => $slug
                ]);
            }
            })->name('getSlug');
    });
});

//session data testing//

Route::get('/all-session', function(Request $request){
  //session('google')->put('url.intended');
 if(session()->has('current_url') !=''){
   echo 'yes';
 }
   //echo'<pre>'; print_r($session);
});


Route::get('/test', [TestController::class,'checkQueryFunction'])->name('test.checkQueryFunction');

Route::get('/set-session', function(Request $request){
      $session = session()->get('url.intended');
      $request->session()->put('current_url',$session);
     //echo'<pre>'; print_r($session);
     return redirect('all-session');
  });

