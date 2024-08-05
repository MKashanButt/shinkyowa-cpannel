<?php

use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(CustomerAccountController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('/customer-account', 'index')->name('customer-accounts');
    Route::get('/agent-customers-account/{agent}', 'agent_customers_account')
        ->name('agent.customer-accounts');
    Route::get('customer-account/destroy/{id}', 'destroy');
    Route::post('/add-customer/post', 'store')->name('add-customer-account');

    Route::get('/add-customer-account', 'render_add_customer_form')->name('add-customer-form');
    Route::get('/customer-account/{id}', 'find')->name('find-customer-account');

    Route::get('/add-customer-payments', 'render_customer_payment_form')->name('customer-payment-form');
    Route::post('/add-customer-payment', 'add_customer_payment')->name('add-customer-payment');

    Route::get('/add-customer-vehicle', 'render_customer_vehicle_form')->name('customer-vehicle-form');
    Route::post('/add-customer-vehicle/post', 'add_customer_vehicle')->name('add-customer-vehicle');

    Route::get('/users', 'render_users');
    Route::get('/user/destroy/{id}', 'destroy_user');
    Route::get('/user/members/{manager}', 'team_members');

    // AJAX ROUTES START
    Route::post('/check-email-availability', 'checkEmailAvailability')->name('check-email-availability');
    Route::get('/find-email', 'findEmail')->name('find-email');
    Route::get('find-stock-id', 'findStockId')->name('find-stock-id');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
