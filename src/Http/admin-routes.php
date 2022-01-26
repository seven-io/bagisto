<?php

use Sms77\Bagisto\Http\Controllers\Sms77Controller;

Route::group([
    'middleware' => ['web', 'admin'],
    'namespace' => 'Sms77\Bagisto\Http\Controllers',
    'prefix' => 'admin',
], function () {

    Route::group(['prefix' => 'sms77'], function () {
        Route::get('', [Sms77Controller::class, 'index'])
            ->name('admin.sms77.index');
        Route::post('sms', [Sms77Controller::class, 'smsSend'])
            ->name('admin.sms77.sms_submit');
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::group(['prefix' => 'sms77'], function () {
            Route::get('sms/{id}', [Sms77Controller::class, 'smsCustomer'])
                ->name('admin.sms77.sms_customer');
        });
    });

    Route::prefix('groups')->group(function () {
        Route::group(['prefix' => 'sms77'], function () {
            Route::get('sms/{id}', [Sms77Controller::class, 'smsCustomerGroup'])
                ->name('admin.sms77.sms_customer_group');
        });
    });
});