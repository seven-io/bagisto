<?php

use Seven\Bagisto\Http\Controllers\BulkController;
use Seven\Bagisto\Http\Controllers\CustomerController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::controller(BulkController::class)->prefix('seven/bulk')->group(function () {
        Route::get('', [BulkController::class, 'index'])->name('admin.seven.index');
        Route::post('', [BulkController::class, 'sms'])->name('admin.seven.sms_submit_bulk');
    });

    Route::controller(CustomerController::class)->prefix('seven/customer')->group(function () {
        Route::post('', [CustomerController::class, 'sms'])->name('admin.seven.sms_submit');
    });
});
