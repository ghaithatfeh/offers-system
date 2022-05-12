<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/customer/change-status/{customer}', [CustomerController::class, 'changeStatus']);
Route::get('/categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
Route::get('/cities/change-status/{city}', [CityController::class, 'changeStatus']);

Route::get('/cities/search', [CityController::class, 'search']);
Route::get('/categories/search', [CategoryController::class, 'search']);

Route::resources([
    '/cities' => CityController::class,
    '/customers' => CustomerController::class,
    '/categories' => CategoryController::class,
    '/tags' => TagController::class
]);

