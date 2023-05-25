<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

it('uses correct User model', function (): void {
    expect(Settings::userClass())
        ->toBe(User::class);
});

it('uses correct impersonate key', function (): void {
    expect(Settings::key())
        ->toBe('user-proxy');
});

it('uses correct MoonShine guard', function (): void {
    enableMoonShineGuard();

    expect(Settings::moonShineGuard())
        ->toBe('moonshine');
});

it('uses default guard if MoonShine guard is disabled', function (): void {
    expect(Settings::moonShineGuard())
        ->toBe('web');
});

it('uses correct default guard', function (): void {
    expect(Settings::defaultGuard())
        ->toBe('web');
});

it('uses correct impersonator session key', function (): void {
    expect(Settings::impersonatorSessionKey())
        ->toBe('impersonator-id');
});

it('uses correct impersonator session guard key', function (): void {
    expect(Settings::impersonatorSessionGuardKey())
        ->toBe('impersonator-guard');
});
