<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Jampire\MoonshineImpersonate\UI\ActionButtons\Contracts\Resolvable;
use Jampire\MoonshineImpersonate\UI\ActionButtons\EnterImpersonationActionButton;
use MoonShine\UI\Components\ActionButton;

use function Pest\Laravel\actingAs;

uses()->group('ui');

it('resolves correct action button class', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve();

    expect($actionButton)
        ->toBeInstanceOf(ActionButton::class)
        ->and($actionButton->getUrl($user))
        ->toBe(route_impersonate('enter', [
            config_impersonate('resource_item_key') => $user->getKey(),
        ]))
        ->and($actionButton->getIcon())
        ->toBe(config_impersonate('buttons.enter.icon'))
        ->and($actionButton->getLabel())
        ->toBe(trans_impersonate('ui.buttons.enter.label'))
        ->and($actionButton->isInDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in in-line mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve()->showInLine();

    expect($actionButton->isInDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in dropdown mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve()->showInDropdown();

    expect($actionButton->isInDropdown())
        ->toBeTrue()
    ;
});

it('implements correct contract', function (): void {
    expect(new EnterImpersonationActionButton())
        ->toBeInstanceOf(Resolvable::class)
    ;
});
