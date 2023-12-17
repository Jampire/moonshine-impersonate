<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User as AuthUser;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\UI\ActionButtons\StopImpersonationActionButton;
use MoonShine\ActionButtons\ActionButton;

use function Pest\Laravel\actingAs;

uses()->group('ui');

it('resolves correct action button class', function (): void {
    // don't need to use User model here
    config(['auth.providers.users.model' => AuthUser::class]);

    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve();

    expect($actionButton)
        ->toBeInstanceOf(ActionButton::class)
        ->and($actionButton->url())
        ->toBe(route_impersonate('stop'))
        ->and($actionButton->iconValue())
        ->toBe(config_impersonate('buttons.stop.icon'))
        ->and($actionButton->label())
        ->toBe(trans_impersonate('ui.buttons.stop.label'))
        ->and($actionButton->inDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in in-line mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve()->showInLine();

    expect($actionButton->inDropdown())
        ->toBeFalse()
    ;
});

it('can show action button in dropdown mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $actionButton = StopImpersonationActionButton::resolve()->showInDropdown();

    expect($actionButton->inDropdown())
        ->toBeTrue()
    ;
});
