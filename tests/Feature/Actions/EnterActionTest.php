<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('actions');

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

    expect($action->execute($user->getKey()))
        ->toBeTrue()
    ;

    Event::assertDispatched(
        ImpersonationEntered::class,
        fn (ImpersonationEntered $event): bool => $event->impersonator->id === $moonShineUser->id
            && $event->impersonated->id === $user->id
    );

    expect($action->execute($user->getKey()))
        ->toBeFalse()
    ;
});

it('cannot execute enter action if user does not found', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute(123))
        ->toBeFalse()
    ;
});

test('enter action cannot be executed on non-impersonated user', function (): void {
    $user = User::factory()->notImpersonated()->create();
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute($user->getKey()))
        ->toBeFalse()
    ;
});

test('enter action cannot be executed by admin with no permission', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect($action->execute($user->getKey()))
        ->toBeFalse()
    ;
});
