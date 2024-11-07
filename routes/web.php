<?php

use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::controller(CustomerAccountController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('/customer-account', 'index')->name('customer-accounts');
    Route::get('/customer-account/edit/{id}', 'fetch_customer_account')->name('customer-accounts.edit-form');
    Route::post('/customer-account/update', 'update_customer_account')->name('customer-accounts.update');
    Route::get('/agent-customers-account/{agent}', 'agent_customers_account')
        ->name('agent.customer-accounts');
    Route::get('customer-account/destroy/{id}', 'destroy');
    Route::post('/add-customer/post', 'store')->name('add-customer-account');

    Route::get('/add-customer-account', 'render_add_customer_form')->name('add-customer-form');
    Route::get('/customer-account/{id}', 'find')->name('find-customer-account');
    Route::get('/customer-account/images/{stockid}', 'findImages')->name('customer-account.images');
    Route::get('/customer-account/docs/{stockid}', 'findDocs')->name('customer-account.docs');
    Route::get('/customer-account/docs/{stockid}/add', function ($stockid) {
        return view('add-docs', [
            'id' => $stockid
        ]);
    })->name('customer-account.add-docs');
    Route::post('/customer-account/docs/upload', 'uploadDocs')->name('customer-account.upload-docs');
    Route::get('/delete-docs', 'deleteDoc')->name('customer-account.delete-doc');
    Route::get('/customer-vehicle/edit/{stockid}', 'fetch_customer_vehicle')->name('customer-vehicle.edit-form');
    Route::post('/customer-vehicle/update', 'edit_customer_vehicle')->name('customer-vehicle.edit');
    Route::get('/customer-vehicle/destroy/{id}', 'destroy_customer_vehicle')->name('customer-vehicle.destroy');

    Route::get('/add-customer-payments', 'render_customer_payment_form')->name('customer-payment-form');
    Route::post('/add-customer-payment', 'add_customer_payment')->name('add-customer-payment');
    Route::get('/customer-payment/edit/{id}', 'fetch_customer_payment')->name('customer-payment.edit-form');
    Route::post('/customer-payment/update', 'edit_customer_payment')->name('customer-payment.update');
    Route::get('/customer-payment/destroy/{id}', 'destroy_customer_payment')->name('customer-payment.destroy');

    Route::get('/add-customer-vehicle', 'render_customer_vehicle_form')->name('customer-vehicle-form');
    Route::post('/add-customer-vehicle/post', 'add_customer_vehicle')->name('add-customer-vehicle');

    Route::get('/users', 'render_users')->name('users');
    Route::get('/user/destroy/{id}', 'destroy_user')->name('users.destory');
    Route::get('/user/members/{manager}', 'team_members')->name('users.team-members');
    Route::get('/user/credentials/{id}', 'user_credentials')->name('user-credentails');
    Route::post('/user/update/', 'update_user_credentials')->name('users.update');

    // AJAX ROUTES START
    Route::post('/check-email-availability', 'checkEmailAvailability')->name('check-email-availability');
    Route::get('/find-email', 'findEmail')->name('find-email');
    Route::get('/find-stock-id', 'findStockId')->name('find-stock-id');

    // SEARCH
    Route::get('/search', 'search')->name('search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
