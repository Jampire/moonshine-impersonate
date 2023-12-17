<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User as AuthUser;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Jampire\MoonshineImpersonate\UI\ActionButtons\EnterImpersonationActionButton;
use MoonShine\ActionButtons\ActionButton;

use function Pest\Laravel\actingAs;

uses()->group('ui');

it('resolves correct action button class', function (): void {
    // don't need to use User model here
    config(['auth.providers.users.model' => AuthUser::class]);

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve();

    expect($actionButton)
        ->toBeInstanceOf(ActionButton::class)
        ->and($actionButton->url($user))
        ->toBe(route_impersonate('enter', [
            config_impersonate('resource_item_key') => $user->getKey(),
        ]))
        ->and($actionButton->iconValue())
        ->toBe(config_impersonate('buttons.enter.icon'))
        ->and($actionButton->label())
        ->toBe(trans_impersonate('ui.buttons.enter.label'))
        ->and($actionButton->inDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in in-line mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve()->showInLine();

    expect($actionButton->inDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in dropdown mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = EnterImpersonationActionButton::resolve()->showInDropdown();

    expect($actionButton->inDropdown())
        ->toBeTrue()
    ;
});
