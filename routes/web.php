<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Jampire\MoonshineImpersonate\Http\Controllers\ImpersonateController;

Route::controller(ImpersonateController::class)
    ->name('impersonate.')
    ->prefix(config('ms-impersonate.routes.prefix'))
    ->middleware(config('ms-impersonate.routes.middleware'))
    ->group(function () {
        Route::post('/enter', 'enter')->name('enter');
        Route::delete('/stop', 'stop')->name('stop');
    });
