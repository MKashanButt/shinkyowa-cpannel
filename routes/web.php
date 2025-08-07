<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\CustomerVehicleController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UrgentPaymentController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\TTController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleDocsController;
use App\Http\Middleware\CustomerAccountRedirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::controller(CustomerAccountController::class)
            ->group(function () {
                Route::get('/', 'dashboard')
                    ->middleware(CustomerAccountRedirect::class)->name('dashboard');

                Route::get('/customer-account', 'index')->name('customer-accounts');
                Route::get('/customer-account/edit/{id}', 'edit_account')->name('customer-accounts.edit-form');
                Route::post('/customer-account/update', 'update')->name('customer-accounts.update');
                Route::get('/agent-customers-account/{agent}', 'agent_customers_account')
                    ->name('agent.customer-accounts');
                Route::get('customer-account/destroy/{id}', 'destroy');
                Route::post('/add-customer/post', 'store')->name('add-customer-account');

                Route::get('/add-customer-account', 'render_form')->name('add-customer-form');
                Route::get('/customer-account/{id}', 'find')->name('find-customer-account');
                Route::get('/export-pdf/{id}', 'export_pdf');
            });

        Route::controller(CustomerVehicleController::class)->group(function () {
            Route::get('/add-customer-vehicle/{email?}', 'render_form')->name('customer-vehicle-form');
            Route::post('/add-customer-vehicle/post', 'store')->name('add-customer-vehicle');
            Route::get('/customer-vehicle/edit/{stockid}', 'find')->name('customer-vehicle.edit-form');
            Route::post('/customer-vehicle/update', 'update')->name('customer-vehicle.edit');
            Route::get('/customer-account/images/{stockid}', 'findImages')->name('customer-account.images');
            Route::get('/customer-vehicle/destroy/{id}', 'destroy')->name('customer-vehicle.destroy');

            Route::get('/customer-vehicle/update-status/{stockid}', 'update_status_form')
                ->name('vehicle.update-status-form');
            Route::post('/customer-vehicle/update-status', 'update_status')
                ->name('vehicle.store-status');
        });

        Route::controller(CustomerPaymentController::class)->group(function () {
            Route::get('/add-customer-payment/{email?}', 'render_form')->name('customer-payment-form');
            Route::post('/add-customer-payment', 'store')->name('add-customer-payment');
            Route::get('/customer-payment/edit/{id}', 'find')->name('customer-payment.edit-form');
            Route::post('/customer-payment/update', 'update')->name('customer-payment.update');
            Route::get('customer-payment/destroy/{id}/{email}/{payment}', 'destroy')->name('customer-payment.destroy');
        });

        Route::controller(VehicleDocsController::class)->group(function () {
            Route::get('/customer-account/docs/{stockid}', 'find')->name('customer-account.docs');
            Route::get('/customer-account/docs/{stockid}/add', 'render_form')->name('customer-account.add-docs');
            Route::post('/customer-account/docs/upload', 'store')->name('customer-account.upload-docs');
            Route::get('/delete-docs', 'delete')->name('customer-account.delete-doc');
            Route::get('/docs/all-docs', 'index')->name('customer-account.all-docs');
            Route::get('/docs/not-uploaded', 'not_uploaded')->name('customer-account.not-uploaded');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users');
            Route::get('/user/destroy/{id}', 'destroy')->name('users.destory');
            Route::get('/user/members/{manager}', 'team_members')->name('users.team-members');
            Route::get('/user/credentials/{id}', 'credentials')->name('user-credentails');
            Route::post('/user/update/', 'update_credentials')->name('users.update');
        });

        Route::resource('stocks', StocksController::class);
        Route::delete('stocks/{id}/deleteImage/{image_name}', [StocksController::class, 'deleteImage'])->name('stocks.deleteImage');

        Route::resource('shipment', ShipmentController::class);
        Route::resource('urgent-payment', UrgentPaymentController::class);

        Route::controller(TTController::class)->group(function () {
            Route::get('/recently-added-tts', 'recently_added')->name('recently-added-tts');
            Route::get('/tt/pending-tts', 'index')->name('tt.pending-tts');
            Route::get('/tt/add-tt', 'store_form')->name('tt.add-form');
            Route::post('/tt/add-tt/store', 'store')->name('tt.store');
            Route::get('/recently-added-tt/proceed-payments/{id}', 'proceed_form')->name('tt.proceed_form');
            Route::post('/recently-added-tt/proceed-payments', 'proceed_store')->name('tt.proceed_store');
            Route::get('/recently-added-tt/destroy/{tt}', 'destroy')->name('tt.destroy');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::controller(InquiryController::class)->group(function () {
            Route::get('/inquiries', 'index')->name('inquiries');
            Route::post('/inquiries/destroy/{id}', 'destroy')->name('inquiries.destroy');
        });

        Route::controller(ApiController::class)->group(function () {
            Route::post('/check-email-availability', 'checkEmailAvailability')->name('check-email-availability');
            Route::get('/find-email', 'findEmail')->name('find-email');
            Route::post('/find-stock-id', 'findStockId')->name('find-stock-id');
            Route::post('/find-stock-id-present', 'findPresentStockId')->name('find-stock-id');

            Route::post('/search/email', 'search')->name('search');
            Route::post('/search/company', 'searchByCompany')->name('search-by-company');
            Route::post('/search/stockid', 'searchByStockId')->name('search-by-stock-id');
        });
    });
require __DIR__ . '/auth.php';
