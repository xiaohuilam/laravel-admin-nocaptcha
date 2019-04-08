<?php
use LaravelAdminExt\Nocaptcha\Controllers\AuthController;

Route::group(['prefix'     => config('admin.route.prefix'), 'middleware' => config('admin.route.middleware'), ], function () {
    Route::get('auth/login', AuthController::class.'@getLogin');
    Route::post('auth/login', AuthController::class.'@postLogin');
});
