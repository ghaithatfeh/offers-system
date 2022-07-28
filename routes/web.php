<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExcelFileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferTypeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Localization Route
Route::get('lang/{locale}', function ($locale) {
    App::setLocale($locale);
    Session::put("locale", $locale);
    return redirect()->back();
})->name('lang');
// Localization Route

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('role:Admin,Supervisor,Store Owner')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password/{user}', [UserController::class, 'changePasswordStore']);
    Route::get('/offers/upload/{offer}', [OfferController::class, 'upload'])->name('offers.upload');
    Route::put('/offers/upload/{offer}', [OfferController::class, 'upload']);
    Route::delete('/offers/delete_image/{image}', [OfferController::class, 'delete_image']);
    Route::resources([
        '/offers' => OfferController::class,
    ]);
});

Route::middleware('role:Store Owner')->group(function () {
    Route::get('/my-store', [StoreController::class, 'myStore'])->name('stores.show');
    Route::get('/my-store/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::get('/bulk-offers/import-from-excel', [ExcelFileController::class, 'importFromExcel'])->name('bulk-offers.import');
    Route::post('/bulk-offers/import-from-excel', [ExcelFileController::class, 'importFromExcel']);
    Route::resources([
        '/bulk-offers' => ExcelFileController::class
    ]);
});

Route::middleware('role:Admin,Supervisor')->group(function () {
    Route::get('/customers/change-status/{customer}', [CustomerController::class, 'changeStatus']);
    Route::get('/categories/change-status/{category}', [CategoryController::class, 'changeStatus']);
    Route::get('/stores/change-status/{store}', [StoreController::class, 'changeStatus']);
    Route::get('/cities/change-status/{city}', [CityController::class, 'changeStatus']);

    Route::get('/cities/search', [CityController::class, 'search']);
    Route::get('/categories/search', [CategoryController::class, 'search']);
    Route::post('/offers/{offer}/review', [OfferController::class, 'review']);
    Route::get('/notification/get-options', [NotificationController::class, 'getOptions']);

    Route::resources([
        '/cities' => CityController::class,
        '/customers' => CustomerController::class,
        '/categories' => CategoryController::class,
        '/tags' => TagController::class,
        '/notifications' => NotificationController::class,
    ]);
});

Route::middleware('role:Admin')->group(function () {
    // Route::get('/stores/upload/{image_type}/{store}', [StoreController::class, 'upload']);
    // Route::put('/stores/upload_store/{image_type}/{store}', [StoreController::class, 'upload_store']);
    // Route::delete('/stores/delete_image/{image_type}/{store}', [StoreController::class, 'delete_image']);
    // Route::get('/offer_types/change-status/{offerType}', [OfferTypeController::class, 'changeStatus']);
    Route::get('/users/change-status/{user}', [UserController::class, 'changeStatus']);
    Route::post('/stores/{store}/expand-expiry', [StoreController::class, 'expandExpiry']);

    Route::resources([
        '/stores' => StoreController::class,
        '/offer_types' => OfferTypeController::class,
        '/users' => UserController::class
    ]);
});

Route::middleware('role:Admin,Store Owner')->group(function () {
    Route::get('/stores/upload/{image_type}/{store}', [StoreController::class, 'upload'])->name('stores.upload');
    Route::get('/my-store/upload/{image_type}/{store}', [StoreController::class, 'upload'])->name('stores.upload');
    Route::put('/stores/upload_store/{image_type}/{store}', [StoreController::class, 'upload_store']);
    Route::delete('/stores/delete_image/{image_type}/{store}', [StoreController::class, 'delete_image']);
    Route::put('/my-store-update/{store}', [StoreController::class, 'myStoreUpdate']);
});
