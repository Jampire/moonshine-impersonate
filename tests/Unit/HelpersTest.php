<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Support\Enums\ToastType;

test('route_impersonate() function returns route', function (): void {
    expect(route_impersonate('enter'))
        ->toBe(route(Settings::ALIAS.'.enter'))
    ;
});

test('config_impersonate() function returns config option', function (): void {
    expect(config_impersonate('key'))
        ->toBe(config(Settings::ALIAS.'.key'))
    ;
});

test('trans_impersonate() function returns translation', function (): void {
    expect(trans_impersonate('ui.buttons.enter.message'))
        ->toBe(trans(Settings::ALIAS.'::ui.buttons.enter.message'))
    ;
});

test('toast_*_if() function flashes message in a session', function (
    ToastType $type,
): void {
    $message = 'hello';

    match ($type) {
        ToastType::SUCCESS => toast_success_if(true, $message),
        ToastType::ERROR => toast_error_if(true, $message),
        default => toast_if(true, $message),
    };

    $session = session();
    expect($session->has('toast'))
        ->toBeTrue()
        ->and($session->get('toast'))
        ->toMatchArray([
            'type' => $type->value,
            'message' => $message,
        ])
    ;
})->with('toast-set');

test('toast_*_if() function does not flash message in a session', function (
    ToastType $type,
): void {
    $message = 'hello';

    match ($type) {
        ToastType::SUCCESS => toast_success_if(false, $message),
        ToastType::ERROR => toast_error_if(false, $message),
        default => toast_if(false, $message),
    };

    expect(session()->has('toast'))
        ->toBeFalse()
    ;
})->with('toast-set');
