<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;

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

test('view_impersonate() function returns View', function (): void {
    expect(view_impersonate('components.impersonate-stop')::class)
        ->toBe(view(Settings::ALIAS.'::components.impersonate-stop')::class)
    ;
});

test('toast_if() function flashes message in a session', function (): void {
    $message = 'hello';
    toast_if(true, $message);

    $session = session();
    expect($session->has('toast'))
        ->toBeTrue()
        ->and($session->get('toast'))
        ->toMatchArray([
            'type' => 'info',
            'message' => $message,
        ])
    ;
});

test('toast_if() function does not flash message in a session', function (): void {
    toast_if(false, 'hello');

    expect(session()->has('toast'))
        ->toBeFalse()
    ;
});
