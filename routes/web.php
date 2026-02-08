<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Jampire\MoonshineImpersonate\Http\Controllers\ImpersonateController;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Laravel\Http\Middleware\ChangeLocale;

$middlewares = config_impersonate('routes.middleware');
$middlewares[] = ChangeLocale::class;

Route::controller(ImpersonateController::class)
    ->name(Settings::ALIAS.'.')
    ->prefix(config_impersonate('routes.prefix'))
    ->middleware($middlewares)
    ->group(function (): void {
        Route::get('/enter', 'enter')->name('enter');
        Route::post('/enter', 'enter')->name('enter-confirm');
        Route::get('/stop', 'stop')->name('stop');
    });
