<?php

declare(strict_types=1);

use Illuminate\Support\Str;

uses()->group('http');

test('GET enter route is correct', function (): void {
    $route = route_impersonate('enter', [
        config_impersonate('resource_item_key') => 123,
    ]);

    expect(Str::endsWith($route, config('moonshine.route.prefix').'/impersonate/enter?resourceItem=123'))
        ->toBeTrue()
    ;
});

test('POST enter route is correct', function (): void {
    $route = route_impersonate('enter-confirm', [
        config_impersonate('resource_item_key') => 123,
    ]);

    expect(Str::endsWith($route, config('moonshine.route.prefix').'/impersonate/enter?resourceItem=123'))
        ->toBeTrue()
    ;
});

test('GET stop route is correct', function (): void {
    $route = route_impersonate('stop');

    expect(Str::endsWith($route, config('moonshine.route.prefix').'/impersonate/stop'))
        ->toBeTrue()
    ;
});
