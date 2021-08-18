<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Home\ProductController as HomeProductController ;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TransactionContoller;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\WishlistController;
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

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');


Route::prefix('/admin')->name('admin.')->group(function(){

    Route::resource('brands', BrandController::class);
    Route::resource('attributes' , AttributeController::class);
    Route::resource('categories' , CategoryController::class);
    Route::resource('tags' , TagController::class);
    Route::resource('products' , ProductController::class);
    Route::resource('comments' , CommentController::class);
    Route::resource('coupons' , CouponController::class);
    Route::resource('orders' , OrderController::class);
    Route::resource('transactions' , TransactionContoller::class);

    //get Category Attribute for product@create from category controller
    Route::get('/category-attributes/{category}' , [CategoryController::class , 'getCategoryAttributes']);

    //editing product images
    Route::get('/products/{product}/edit-images' , [ProductImageController::class , 'edit'])->name('products.images.edit') ;
    Route::delete('/products/{product}/images-destroy' , [ProductImageController::class , 'destroy'])->name('products.images.destroy') ;
    Route::put('/products/{product}/set-primary-image' , [ProductImageController::class , 'set_primary'])->name('products.images.set_primary') ;
    Route::post('/products/{product}/add-images' , [ProductImageController::class , 'add'])->name('products.images.add') ;

    // Updating product Categroies and Attributes
    Route::get('/product/{product}/edit-category' , [ProductController::class , 'edit_category'])->name('products.category.edit');
    Route::put('/product/{product}/update-category' , [ProductController::class , 'update_category'])->name('products.category.update');

    // Banner Controller
    Route::resource('banners', BannerController::class);

});


Route::prefix('/profile')->name('home.')->middleware('auth')->group(function(){
    Route::get('/' , [ProfileController::class , 'index'])->name('profile.index');
    Route::get('/comments' , [HomeCommentController::class , 'comments'])->name('profile.comments');
    Route::get('/orders' , [ProfileController::class , 'orders'])->name('profile.orders');
    Route::get('/addresses' , [AddressController::class , 'index'])->name('profile.address');
    Route::post('/addresses' , [AddressController::class , 'store'])->name('profile.address.store');
    Route::put('/address/{address}' , [AddressController::class , 'update'])->name('profile.address.update');
    Route::get('/wishlist' , [WishlistController::class , 'index'])->name('profile.wishlist');
});
//geting cities list api
Route::get('/get-province-cities-list' , [AddressController::class , 'getCities']);

//add to wishlist
Route::get('/addToWishlist/{product:id}' , [WishlistController::class , 'add'])->name('home.add')->middleware('auth');
Route::get('/removeFromWishlist/{product:id}' , [WishlistController::class , 'remove'])->name('home.remove')->middleware('auth');
// end of wishlist

Route::get('/', [HomeController::class , 'index'])->name('home.index');
Route::get('/categories/{category:slug}', [HomeCategoryController::class , 'show'])->name('home.categories.show');
Route::get('/product/{product:slug}', [HomeProductController::class , 'show'])->name('home.products.show');

Route::get('/logout' , function(){
    auth()->logout();
    return redirect()->route('home.index');
});

Route::get('/login/{provider}'  , [AuthController::class , 'redirectToProvider'])->name('provider.login');
Route::get('/login/{provider}/callback'  , [AuthController::class , 'handleProviderCallback']);

// for comments
Route::post('/comments/{product}' , [HomeCommentController::class , 'store'])->name('home.comments.store')->middleware('auth');

//add to cart
Route::get('/cart',[CartController::class , 'index'])->name('home.cart.index');
Route::post('/add-to-cart',[CartController::class , 'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{rowId}',[CartController::class , 'remove'])->name('home.cart.remove');
Route::put('/cart',[CartController::class , 'update'])->name('home.cart.update');
Route::get('/clear-cart',[CartController::class , 'clear'])->name('home.cart.clear');
Route::post('/check-coupon' , [CartController::class , 'checkCoupon'])->name('home.coupons.check');
Route::get('/remove-coupon' , [CartController::class , 'removeCoupon'])->name('home.coupons.remove');
//trying to use ajax with jquery
Route::get('/coupons-info/{coupon:id}' , [CartController::class , 'getCouponsInfo']);
//checkout
Route::get('/checkout' ,[CartController::class , 'checkout'])->name('home.orders.checkout')->middleware('auth');
Route::post('/payment' , [PaymentController::class , 'payment'])->name('home.payment')->middleware('auth');
Route::get('/payment-verify/{gatewayName}', [PaymentController::class, 'paymentVerify'])->name('home.payment_verify');

Route::get('/about-us' , [HomeController::class , 'aboutUs'])->name('home.about_us');
Route::get('/contact-us' , [HomeController::class , 'contactUs'])->name('home.contact_us');
Route::post('/contact-us' , [HomeController::class , 'contactUsSend'])->name('home.contact_us.send');
