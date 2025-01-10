<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-orders',[UserController::class,'account_orders'])->name('user.account.orders');
    Route::get('/account-order-detials/{order_id}',[UserController::class,'account_order_details'])->name('user.acccount.order.details');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products');
    Route::get('/admin/product/add',[AdminController::class,'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class,'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit',[AdminController::class,'edit_product'])->name('admin.product.edit');
    Route::put('/admin/product/update',[AdminController::class,'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete',[AdminController::class,'delete_product'])->name('admin.product.delete');
    Route::get('/admin/product/{id}', [AdminController::class, 'show'])->name('admin.product.show');

    Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
    Route::get('/shop/{product_slug}',[ShopController::class,'product_details'])->name("shop.product.details");

    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');
    Route::put('/cart/increase-qunatity/{rowId}',[CartController::class,'increase_item_quantity'])->name('cart.increase.qty');
    Route::put('/cart/reduce-qunatity/{rowId}',[CartController::class,'reduce_item_quantity'])->name('cart.reduce.qty');
    Route::delete('/cart/remove/{rowId}',[CartController::class,'remove_item_from_cart'])->name('cart.remove');
    Route::delete('/cart/clear',[CartController::class,'empty_cart'])->name('cart.empty');

    Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');

    Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
    Route::get('/admin/order/items/{order_id}',[AdminController::class,'order_items'])->name('admin.order.items');

    Route::post('/place-order',[CartController::class,'place_order'])->name('cart.place.order');
    Route::get('/order-confirmation',[CartController::class,'confirmation'])->name('cart.confirmation');
    Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.status.update');

});