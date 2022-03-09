<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// Auth::routes();

// user login - register - logout
Route::prefix('/') -> group(function() {
    Route::get('', 'GuestController@home')->name('home');
    Route::get('login', 'GuestController@loginRegister')->name('login-register');
    Route::post('login', 'Auth\LoginController@login') -> name('login');
    Route::post('register', 'Auth\RegisterController@register') -> name('register');
    Route::get('logout', 'Auth\LoginController@logout') -> name('logout');
});

// return dashboard page
Route::get('/dashboard', function(){
    return view('pages.dashboard');
});


// api routes
Route::prefix('/api') -> group(function() { 
    // logged users 
    Route::get('/dishes', 'ApiController@getMenu') -> name('api.dishes');
    Route::get('/categories', 'ApiController@getCategories') -> name('api.categories');
    Route::post('/store', 'ApiController@addDish');
    Route::post('/edit', 'ApiController@edit');
    Route::post('/updateDish/{id}', 'ApiController@updateDish') -> name('update');
    Route::get('/dishDelete/{id}', 'ApiController@deleteDish') -> name('delate');
    Route::get('/get/restaurant/menu/{id}', 'ApiController@getRestaurantMenu') -> name('menu');
    // guests
    Route::get('/cart/checkout', 'ApiController@checkout') -> name('api.cart.checkout');
});


Route::get('/orders/generate', 'OrderController@generate');
Route::post('/orders/customerInfo', 'OrderController@customerInfo');
Route::post('/orders/createOrder', 'OrderController@createOrder');
Route::post('/orders/make/payment', 'OrderController@makePayment');


Route::get('/all/dishes', 'DishController@index');

Route::get('/restaurant/details/{id}', 'GuestController@getRestaurant') -> name('restaurant');

Route::prefix('/chart') -> group(function() { 
    Route::get('/months', 'DishController@index');
    Route::get('/orders', 'DishController@index');
});
