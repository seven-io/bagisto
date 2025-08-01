<?php

use Seven\Bagisto\Http\Controllers\SevenController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::controller(SevenController::class)->prefix('seven')->group(function () {
        Route::get('', [SevenController::class, 'index'])->name('admin.seven.index');
        Route::post('sms', [SevenController::class, 'smsSend'])->name('admin.seven.sms_submit');
    });

    Route::controller(SevenController::class)->prefix('/customers/seven')->group(function () {
        Route::get('sms/{id}', [SevenController::class, 'smsCustomer'])
            ->name('admin.seven.sms_customer');
    });

    Route::controller(SevenController::class)->prefix('/groups/seven')->group(function () {
        Route::get('sms/{id}', [SevenController::class, 'smsCustomerGroup'])
            ->name('admin.seven.sms_customer_group');
    });
});
