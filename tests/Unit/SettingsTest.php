<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User;
use Jampire\MoonshineImpersonate\Support\Settings;

it('uses correct User model', function () {
    expect(Settings::userClass())
        ->toBe(User::class);
});

it('uses correct impersonate key', function () {
    expect(Settings::key())
        ->toBe('user-proxy');
});

it('uses correct MoonShine guard', function () {
    enableMoonShineGuard();

    expect(Settings::moonShineGuard())
        ->toBe('moonshine');
});

it('uses default guard if MoonShine guard is disabled', function () {
    expect(Settings::moonShineGuard())
        ->toBe('web');
});

it('uses correct default guard', function () {
    expect(Settings::defaultGuard())
        ->toBe('web');
});

it('uses correct impersonator session key', function () {
    expect(Settings::impersonatorSessionKey())
        ->toBe('impersonator-id');
});

it('uses correct impersonator session guard key', function () {
    expect(Settings::impersonatorSessionGuardKey())
        ->toBe('impersonator-guard');
});
