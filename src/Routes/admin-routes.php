<?php

use Seven\Bagisto\Http\Controllers\SevenController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::controller(SevenController::class)->prefix('seven')->group(function () {
        Route::get('', [SevenController::class, 'index'])->name('admin.seven.index');
        Route::post('sms', [SevenController::class, 'sms'])->name('admin.seven.sms_submit');
    });
});
