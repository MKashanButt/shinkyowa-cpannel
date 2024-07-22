<?php

use App\Http\Controllers\CustomerAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        "title" => "Shinkyowa Cpannel",
    ]);
});

Route::controller(CustomerAccountController::class)->group(function () {
    Route::get('/customer-account', 'index')->name('customer-account');
    Route::post('/add-customer/post', 'store')->name('add-customer-account');

    Route::get('/add-customer-account', 'render_add_customer_form')->name('add-customer-form');
    Route::get('/customer-account/{id}', 'find')->name('find-customer-account');

    Route::get('/add-customer-payments', 'render_customer_payment_form')->name('customer-payment-form');
    Route::post('/add-customer-payment', 'add_customer_payment')->name('add-customer-payment');

    Route::get('/add-customer-vehicle', 'render_customer_vehicle_form')->name('customer-vehicle-form');
    Route::post('/add-customer-vehicle/post', 'add_customer_vehicle')->name('add-customer-vehicle');

    // AJAX ROUTES START
    Route::post('/check-email-availability', 'checkEmailAvailability')->name('check-email-availability');
    Route::get('/find-email', 'findEmail')->name('find-email');
    Route::get('/vehicle/find-stock-id', 'findStockIdForVehicle')->name('vehicle.find-stock-id');
    Route::get('/payment/find-stock-id', 'findStockIdForPayment')->name('payment.find-stock-id');
    // AJAX ROUTES END
});
