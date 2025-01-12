<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\TypeStatusController;
use App\Http\Controllers\TypeCrestController;
use App\Http\Controllers\TypeSizeController;
use App\Http\Controllers\TypeFlowerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Default\FileController;
use App\Http\Controllers\Default\GeneralController;
use App\Http\Controllers\Default\PermissionController;
use App\Http\Controllers\Default\ProfileController;
use App\Http\Controllers\Default\RoleController;
use App\Http\Controllers\Default\SettingController;
use App\Http\Controllers\Default\UserController;
use Illuminate\Support\Facades\Route;

// define module as main route
// Route::get('/', [App\Module\Shortlink\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('/login');
});

Route::get('files/{file}', [FileController::class, 'show'])->name('file.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');
    Route::get('/maintance', [GeneralController::class, 'maintance'])->name('maintance');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Permission
    Route::delete('_permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::put('_permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('_permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('_permissions', [PermissionController::class, 'index'])->name('permissions.index');

    // Role
    Route::resource('/roles', RoleController::class);

    // Setting
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('setting.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // #Admin
Route::resource('orders', OrderController::class);
Route::delete('customers/{customer}', [CustomerController::class,'destroy'])->name('customers.destroy');
Route::put('customers/{customer}', [CustomerController::class,'update'])->name('customers.update');
Route::post('customers', [CustomerController::class,'store'])->name('customers.store');
Route::get('customers', [CustomerController::class,'index'])->name('customers.index');
Route::delete('couriers/{courier}', [CourierController::class,'destroy'])->name('couriers.destroy');
Route::put('couriers/{courier}', [CourierController::class,'update'])->name('couriers.update');
Route::post('couriers', [CourierController::class,'store'])->name('couriers.store');
Route::get('couriers', [CourierController::class,'index'])->name('couriers.index');
Route::delete('type-statuses/{typeStatus}', [TypeStatusController::class,'destroy'])->name('type-statuses.destroy');
Route::put('type-statuses/{typeStatus}', [TypeStatusController::class,'update'])->name('type-statuses.update');
Route::post('type-statuses', [TypeStatusController::class,'store'])->name('type-statuses.store');
Route::get('type-statuses', [TypeStatusController::class,'index'])->name('type-statuses.index');
Route::delete('type-crests/{typeCrest}', [TypeCrestController::class,'destroy'])->name('type-crests.destroy');
Route::put('type-crests/{typeCrest}', [TypeCrestController::class,'update'])->name('type-crests.update');
Route::post('type-crests', [TypeCrestController::class,'store'])->name('type-crests.store');
Route::get('type-crests', [TypeCrestController::class,'index'])->name('type-crests.index');
Route::delete('type-sizes/{typeSize}', [TypeSizeController::class,'destroy'])->name('type-sizes.destroy');
Route::put('type-sizes/{typeSize}', [TypeSizeController::class,'update'])->name('type-sizes.update');
Route::post('type-sizes', [TypeSizeController::class,'store'])->name('type-sizes.store');
Route::get('type-sizes', [TypeSizeController::class,'index'])->name('type-sizes.index');
Route::delete('type-flowers/{typeFlower}', [TypeFlowerController::class,'destroy'])->name('type-flowers.destroy');
Route::put('type-flowers/{typeFlower}', [TypeFlowerController::class,'update'])->name('type-flowers.update');
Route::post('type-flowers', [TypeFlowerController::class,'store'])->name('type-flowers.store');
Route::get('type-flowers', [TypeFlowerController::class,'index'])->name('type-flowers.index');
Route::delete('stores/{store}', [StoreController::class,'destroy'])->name('stores.destroy');
Route::put('stores/{store}', [StoreController::class,'update'])->name('stores.update');
Route::post('stores', [StoreController::class,'store'])->name('stores.store');
Route::get('stores', [StoreController::class,'index'])->name('stores.index');
});

// #Guest


// Route::get('/{link:code}', [App\Module\Shortlink\Controllers\HomeController::class, 'redirect'])->name('redirect');