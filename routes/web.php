<?php

use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;

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

Route::get('/', 'FrontendController@index')->name('welcome');
Route::get('on-sale', 'FrontendController@onSale')->name('on-sale');
Route::get('/category/{slug}', 'FrontendController@category')->name('frontendCategory');
Route::get('/categories', 'FrontendController@categories')->name('frontendCategories');
Route::get('/sub-category/{slug}', 'FrontendController@subcategory')->name('subcategory');
Route::get('/product/{slug}', 'FrontendController@show')->name('single-product');
Route::post('/contact', 'FrontendController@contactStore')->name('store-contact');
Route::get('/contact', 'FrontendController@contact')->name('contact-us');

Route::resource('cart', 'CartController');
Route::post('coupons', 'CouponsController@store')->name('coupons.store');
Route::delete('coupons', 'CouponsController@destroy')->name('coupons.destroy');
Route::get('empty', function () {
	Cart::destroy();
});

Route::middleware('auth')->group(function () {
	Route::get('my-orders', 'ProfileController@index')->name('my-orders.index');
	Route::get('my-profile', 'ProfileController@edit')->name('my-profile.edit');
	Route::post('my-profile', 'ProfileController@update')->name('my-profile.store');
	Route::get('my-orders/{id}', 'ProfileController@show')->name('my-profile.show');
	Route::resource('orders', 'OrderController');
	Route::resource('checkout', 'CheckoutController');
});

Auth::routes();
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::middleware(['auth', 'admin'])->group(function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('admin/users', 'Admin\UserController');
	Route::resource('admin/slides', 'Admin\SlideController');
	Route::resource('admin/categories', 'Admin\CategoryController');
	Route::resource('admin/subcategories', 'Admin\SubCategoryController');
	Route::delete('admin/products/photo/{id}', 'Admin\ProductController@destroyImage')->name('destroyImage');
	Route::delete('admin/products/attribute/{id}', 'Admin\ProductController@destroyAttribute')->name('destroyAttribute');
	Route::resource('admin/coupon', 'Admin\CouponController');
	Route::resource('admin/products', 'Admin\ProductController');
	Route::resource('admin/system-settings', 'Admin\SystemSettingsController');
	Route::get('/admin/contact', 'Admin\MessageController@index')->name('contactMessages');
	Route::get('/admin/orders', 'Admin\OrderController@index')->name('orders.index');
	Route::get('/admin/orders/{id}', 'Admin\OrderController@show')->name('orders.show');
});
