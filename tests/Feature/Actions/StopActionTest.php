<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Actions\StopAction;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('actions');

beforeEach(function (): void {
    setAuthConfig();
    enableMoonShineGuard();
});

test('stop action can be executed', function (): void {
    Event::fake();

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());
    app(ImpersonateManager::class)->saveAuthInSession($user);

    $action = app(StopAction::class);

    expect($action->execute())
        ->toBeTrue()
    ;

    Event::assertDispatched(
        ImpersonationStopped::class,
        fn (ImpersonationStopped $event): bool => $event->impersonator->id === $moonShineUser->id
            && $event->impersonated->id === $user->id
    );

    expect($action->execute())
        ->toBeFalse()
    ;
});

it('cannot execute stop action if user does not found', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(StopAction::class);

    expect($action->execute())
        ->toBeFalse();
});

it('cannot execute stop action if non-user is in session', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());
    session([
        Settings::key() => PHP_INT_MAX,
    ]);

    $action = app(StopAction::class);

    expect($action->execute())
        ->toBeFalse();
});

test('stop action can be executed by admin with no permission', function (): void {
    // Because admin was able to enter impersonation, but later their permission was revoked.
    // Admin should be able to clear their session.
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());
    app(ImpersonateManager::class)->saveAuthInSession($user);

    $action = app(StopAction::class);

    expect($action->execute())
        ->toBeTrue()
    ;
});
