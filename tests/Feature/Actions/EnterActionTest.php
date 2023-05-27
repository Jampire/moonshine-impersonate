<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;

use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    setAuthConfig();
    enableMoonShineGuard();
});

test('enter action validation works correctly', function (): void {
    Event::fake();

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute($user->getKey(), true))
        ->toBeTrue()
        ->and($action->execute($user->getKey(), true))
        ->toBeFalse()
    ;
});

it('cannot execute enter action if user does not found', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect(fn () => $action->execute(123))
        ->toThrow(ModelNotFoundException::class)
    ;
});

test('enter action cannot be executed on non-impersonated user', function (): void {
    $user = User::factory()->notImpersonated()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute($user->getKey(), true))
        ->toBeFalse()
    ;
});

test('enter action cannot be executed by admin with no permission', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute($user->getKey(), true))
        ->toBeFalse()
    ;
});
