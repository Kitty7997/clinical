<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicalRoute;
use App\Http\Controllers\AddToCart;

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

Route::get('/',[ClinicalRoute::class,'ClinicalRoute']);
Route::post('/add_to_cart',[AddToCart::class,'addTocart']);
Route::get('/cart',[AddToCart::class,'viewCart']);
Route::get('/remove/{id}', [AddToCart::class, 'removeData']);
// Route::get('/total',[AddToCart::class, 'cartItem']);

