<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Jampire\MoonshineImpersonate\Http\Controllers\ImpersonateController;
use Jampire\MoonshineImpersonate\Support\Settings;

Route::controller(ImpersonateController::class)
    ->name(Settings::ALIAS.'.')
    ->prefix(config_impersonate('routes.prefix'))
    ->middleware(config_impersonate('routes.middleware'))
    ->group(function (): void {
        Route::post('/enter', 'enter')->name('enter');
        Route::get('/stop', 'stop')->name('stop');
    });
