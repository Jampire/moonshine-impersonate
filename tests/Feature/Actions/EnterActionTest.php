<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;

use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    setAuthConfig();
    enableMoonShineGuard();
});

it('cannot execute enter action if user does not found', function () {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = app(EnterAction::class);

    expect(fn () => $action->execute(123))
        ->toThrow(ModelNotFoundException::class)
    ;
});

test('enter action validation works correctly', function () {
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
