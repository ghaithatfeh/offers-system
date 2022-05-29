<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferTypeController;
use App\Http\Controllers\StoreController;
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
    return redirect('/login');
});
Auth::routes();



Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/customer/change-status/{customer}', [CustomerController::class, 'changeStatus']);
    Route::get('/categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
    Route::get('/cities/change-status/{city}', [CityController::class, 'changeStatus']);
    Route::get('/offer_types/change-status/{offerType}', [OfferTypeController::class, 'changeStatus']);
    Route::get('/stores/upload/{image_type}/{store}', [StoreController::class, 'upload']);
    Route::put('/stores/upload_store/{image_type}/{store}', [StoreController::class, 'upload_store']);

    Route::get('/cities/search', [CityController::class, 'search']);
    Route::get('/categories/search', [CategoryController::class, 'search']);
    Route::post('/offers/{offer}/review', [OfferController::class, 'review']);
    Route::get('/notification/get-options', [NotificationController::class, 'getOptions']);

    return Route::resources([
        '/cities' => CityController::class,
        '/customers' => CustomerController::class,
        '/categories' => CategoryController::class,
        '/tags' => TagController::class,
        '/offer_types' => OfferTypeController::class,
        '/offers' => OfferController::class,
        '/stores' => StoreController::class,
        '/notifications' => NotificationController::class,
    ]);
});
