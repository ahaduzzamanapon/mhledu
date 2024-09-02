<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Fees\Http\Controllers\EkpayPaymentController;

Route::get('/', 'LandingController@index')->name('/');
// if (config('app.app_sync')) {
// }

if (moduleStatusCheck('Saas')) {
    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}.' . config('app.short_url')], function ($routes) {
        require('tenant.php');
    });

    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}'], function ($routes) {
        require('tenant.php');
    });
}

// Route::post('ek-payment-success', [EkpayPaymentController::class, 'ekPaySuccess'])->name('success');
// Route::post('ek-response-ekpay-ipn-tax', [EkpayPaymentController::class, 'fail'])->name('fail');
// Route::post('ek-payment-cancel', [EkpayPaymentController::class, 'ekPayCancel'])->name('cancel');
// Route::any('ek-payment-success', [EkpayPaymentController::class, 'ekPaySuccess']);




Route::group(['middleware' => ['subdomain']], function ($routes) {
    require('tenant.php');
});

Route::get('migrate', function () {
    if(Auth::check() && Auth::id() == 1){
        \Artisan::call('migrate', ['--force' => true]);
        \Brian2694\Toastr\Facades\Toastr::success('Migration run successfully');
        return redirect()->to(url('/admin-dashboard'));
    }
    abort(404);
});


Route::post('editor/upload-file', 'UploadFileController@upload_image');
