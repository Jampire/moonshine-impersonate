<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Jampire\MoonshineImpersonate\Http\Controllers\ImpersonateController;
use Jampire\MoonshineImpersonate\Support\Settings;

Route::controller(ImpersonateController::class)
    ->name(Settings::ALIAS.'.')
    ->prefix(config('ms-impersonate.routes.prefix'))
    ->middleware(config('ms-impersonate.routes.middleware'))
    ->group(function () {
        Route::post('/enter', 'enter')->name('enter');
        Route::get('/stop', 'stop')->name('stop');
    });
