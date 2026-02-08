<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\UI\ActionButtons\Contracts\Resolvable;
use Jampire\MoonshineImpersonate\UI\ActionButtons\StopImpersonationActionButton;
use MoonShine\UI\Components\ActionButton;

use function Pest\Laravel\actingAs;

uses()->group('ui');

it('resolves correct action button class', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve();

    expect($actionButton)
        ->toBeInstanceOf(ActionButton::class)
        ->and($actionButton->getUrl())
        ->toBe(route_impersonate('stop'))
        ->and($actionButton->getIcon())
        ->toBe(config_impersonate('buttons.stop.icon'))
        ->and($actionButton->getLabel())
        ->toBe(trans_impersonate('ui.buttons.stop.label'))
        ->and($actionButton->isInDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in in-line mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve()->showInLine();

    expect($actionButton->isInDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in dropdown mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve()->showInDropdown();

    expect($actionButton->isInDropdown())
        ->toBeTrue()
    ;
});

it('implements correct contract', function (): void {
    expect(new StopImpersonationActionButton())
        ->toBeInstanceOf(Resolvable::class)
    ;
});
