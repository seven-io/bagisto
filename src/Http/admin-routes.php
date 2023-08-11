<?php

use Seven\Bagisto\Http\Controllers\SevenController;

Route::group([
    'middleware' => ['web', 'admin'],
    'namespace' => 'Seven\Bagisto\Http\Controllers',
    'prefix' => 'admin',
], function () {

    Route::group(['prefix' => 'seven'], function () {
        Route::get('', [SevenController::class, 'index'])
            ->name('admin.seven.index');
        Route::post('sms', [SevenController::class, 'smsSend'])
            ->name('admin.seven.sms_submit');
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::group(['prefix' => 'seven'], function () {
            Route::get('sms/{id}', [SevenController::class, 'smsCustomer'])
                ->name('admin.seven.sms_customer');
        });
    });

    Route::prefix('groups')->group(function () {
        Route::group(['prefix' => 'seven'], function () {
            Route::get('sms/{id}', [SevenController::class, 'smsCustomerGroup'])
                ->name('admin.seven.sms_customer_group');
        });
    });
});
