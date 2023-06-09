<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User as AuthUser;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Jampire\MoonshineImpersonate\UI\ItemActions\EnterImpersonationItemAction;

use MoonShine\ItemActions\ItemAction;

use function Pest\Laravel\actingAs;

it('resolves correct item action class', function (): void {
    // don't need to use User model here
    config(['auth.providers.users.model' => AuthUser::class]);

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $itemAction = EnterImpersonationItemAction::make()->resolve();

    expect($itemAction)
        ->toBeInstanceOf(ItemAction::class)
        ->and($itemAction->callback($user))
        ->toBeTrue()
        ->and($itemAction->message())
        ->toBe(trans_impersonate('ui.buttons.enter.message'))
        ->and($itemAction->iconValue())
        ->toBe(config_impersonate('buttons.enter.icon'))
        ->and($itemAction->label())
        ->toBe(trans_impersonate('ui.buttons.enter.label'))
        ->and($itemAction->inDropdown())
        ->toBeTrue()
    ;
});

it('can show item action in in-line mode', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $itemAction = EnterImpersonationItemAction::make()->resolve()->showInLine();

    expect($itemAction->inDropdown())
        ->toBeFalse()
    ;
});

it('can show confirmation dialog for this item action', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $itemAction = EnterImpersonationItemAction::make()->resolve()->withConfirm();

    expect($itemAction->confirmation())
        ->toBeTrue()
    ;
});
