<?php

use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\CustomerVehicleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TTController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleDocsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::controller(CustomerAccountController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('/customer-account', 'index')->name('customer-accounts');
    Route::get('/customer-account/edit/{id}', 'edit_account')->name('customer-accounts.edit-form');
    Route::post('/customer-account/update', 'update')->name('customer-accounts.update');
    Route::get('/agent-customers-account/{agent}', 'agent_customers_account')
        ->name('agent.customer-accounts');
    Route::get('customer-account/destroy/{id}', 'destroy');
    Route::post('/add-customer/post', 'store')->name('add-customer-account');

    Route::get('/add-customer-account', 'render_form')->name('add-customer-form');
    Route::get('/customer-account/{id}', 'find')->name('find-customer-account');

    // AJAX ROUTES START
    Route::post('/check-email-availability', 'checkEmailAvailability')->name('check-email-availability');
    Route::get('/find-email', 'findEmail')->name('find-email');
    Route::post('/find-stock-id', 'findStockId')->name('find-stock-id');

    // SEARCH
    Route::get('/search', 'search')->name('search');
});

Route::controller(CustomerVehicleController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/add-customer-vehicle/{email?}', 'render_form')->name('customer-vehicle-form');
    Route::post('/add-customer-vehicle/post', 'store')->name('add-customer-vehicle');
    Route::get('/customer-vehicle/edit/{stockid}', 'find')->name('customer-vehicle.edit-form');
    Route::post('/customer-vehicle/update', 'update')->name('customer-vehicle.edit');
    Route::get('/customer-account/images/{stockid}', 'findImages')->name('customer-account.images');
    Route::get('/customer-vehicle/destroy/{id}', 'destroy')->name('customer-vehicle.destroy');
});

Route::controller(CustomerPaymentController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/add-customer-payment/{email?}', 'render_form')->name('customer-payment-form');
    Route::post('/add-customer-payment', 'store')->name('add-customer-payment');
    Route::get('/customer-payment/edit/{id}', 'find')->name('customer-payment.edit-form');
    Route::post('/customer-payment/update', 'update')->name('customer-payment.update');
    Route::get('customer-payment/destroy/{id}/{email}/{payment}', 'destroy')->name('customer-payment.destroy');
});

Route::controller(VehicleDocsController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/customer-account/docs/{stockid}', 'find')->name('customer-account.docs');
    Route::get('/customer-account/docs/{stockid}/add', 'render_form')->name('customer-account.add-docs');
    Route::post('/customer-account/docs/upload', 'store')->name('customer-account.upload-docs');
    Route::get('/delete-docs', 'delete')->name('customer-account.delete-doc');
});

Route::controller(UserController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/users', 'index')->name('users');
    Route::get('/user/destroy/{id}', 'destroy')->name('users.destory');
    Route::get('/user/members/{manager}', 'team_members')->name('users.team-members');
    Route::get('/user/credentials/{id}', 'credentials')->name('user-credentails');
    Route::post('/user/update/', 'update_credentials')->name('users.update');
});

Route::controller(TTController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/recently-added-tts', 'recently_added')->name('recently-added-tts');
    Route::get('/tt/pending-tts', 'index')->name('tt.pending-tts');
    Route::get('/tt/add-tt', 'store_form')->name('tt.add-form');
    Route::post('/tt/add-tt/store', 'store')->name('tt.store');
    Route::get('/recently-added-tt/proceed-payments/{id}', 'proceed_form')->name('recently-added-tts');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
