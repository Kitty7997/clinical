<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;


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
// Route::middleware([CheckStatus::class])->group(function(){
    Route::middleware('checkstatus')->group(function(){
    Route::get('/addons',[AddonController::class, 'addOn'])->name('addons');
    

    // Cart routes
    Route::get('/cart',[CartController::class,'viewCart'])->name('cart');
    Route::post('/add_to_cart',[CartController::class,'addTocart']);
    Route::post('/apply_coupon',[CartController::class,'applyCoupon'])->name('apply_coupon');
    Route::get('/remove/{id}', [CartController::class, 'removeData'])->name('remove/{id}');
    Route::post('/forget',[CartController::class,'forgetCart']);

    // Delivery routes
    Route::get('/delivery',[DeliveryController::class,'dealControl'])->name('delivery');
    Route::post('/postdelivery',[DeliveryController::class,'addData'])->name('postdelivery');
    Route::get('/delete/{id}',[DeliveryController::class,'deleteData'])->name('delete/{id}');
    Route::get('/edit/{id}',[DeliveryController::class,'editData'])->name('edit/{id}');
    Route::post('/update/{id}',[DeliveryController::class,'updateData'])->name('update/{id}');
    Route::get('/continue/{id}',[DeliveryController::class,'continueData'])->name('continue/{id}');

    // Payment routes
    Route::get('/payment',[PaymentController::class,'paymentController'])->name('payment');
    Route::post('/billadd',[PaymentController::class,'billAdd'])->name('billadd');
    Route::get('/billedit/{id}',[PaymentController::class,'paymentEditController'])->name('billedit/{id}');
    Route::post('/editbilladd/{id}',[PaymentController::class,'editbill'])->name('editbilladd/{id}');
    Route::get('/deletebill/{id}',[PaymentController::class,'deleteBill'])->name('deletebill/{id}');
    

    // stripe routes
    Route::get('/stripe',[StripePaymentController::class,'stripe']);
    Route::post('/stripepost',[StripePaymentController::class,'stripePost'])->name('stripe.payment');
    Route::get('stripe-response/{id}', [StripeController::class, 'response'])->name('stripeResponse');

    //order routes
    Route::get('/order',[OrderController::class,'orderNow'])->name('order');
    Route::get('/orderremove/{id}',[OrderController::class,'removeorder']);

    // coupon routes
    Route::post('/coupon',[CouponController::class,'couponApply']);

});

    Route::get('/',[ProductController::class,'ClinicalRoute'])->name('/');
    
    // Account routes
    Route::get('/register',[RegisterController::class,'accountPage'])->name('register');
    Route::post('/postregister',[RegisterController::class,'postLogin'])->name('postregister');
    Route::get('/login',[RegisterController::class,'loginPage'])->name('login');
    Route::post('/postlogin',[RegisterController::class,'loginPost'])->name('postlogin');
    Route::get('/forgot-password',[RegisterController::class,'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password2',[RegisterController::class,'postforgot'])->name('forgot-password2');
    Route::get('/reset-password/{token}',[RegisterController::class,'resetPassword'])->name('reset');
    Route::get('/logouttt',[RegisterController::class,'logout'])->name('logouttt');



    // Google routes
    Route::get('auth/google', [GoogleController::class, 'signInwithGoogle']);
    Route::get('callback/google', [GoogleController::class, 'callbackToGoogle']);


    



