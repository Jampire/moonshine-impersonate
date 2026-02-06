<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('http');

beforeEach(function (): void {
    setAuthConfig();
    enableMoonShineGuard();
});

test('privileged user can impersonate another user', function (
    string $method,
): void {
    Event::fake();

    $user = User::factory()->create([
        'name' => 'user',
    ]);
    $moonShineUser = MoonshineUser::factory()->create([
        'name' => 'admin',
    ]);

    actingAs($moonShineUser, Settings::moonShineGuard());

    $response = enterResponse($user->id, $method);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin');

    $session = session();
    expect($session->get(config_impersonate('key')))
        ->toBe($user->id)
        ->and($session->get(Settings::impersonatorSessionKey()))
        ->toBe($moonShineUser->getKey())
        ->and($session->get(Settings::impersonatorSessionGuardKey()))
        ->toBe(Settings::moonShineGuard())
        ->and(auth(Settings::moonShineGuard())->user()->name)
        ->toBe($moonShineUser->name)
        ->and($session->get('toast'))
        ->toMatchArray([
            'type' => 'success',
            'message' => trans_impersonate('ui.buttons.enter.message'),
        ])
    ;

    Event::assertDispatched(
        fn (ImpersonationEntered $event): bool =>
            $event->impersonator->getAuthIdentifier() === $moonShineUser->id &&
            $event->impersonated->getAuthIdentifier() === $user->id
    );
})->with('enter-routes');

test('unauthorized user cannot impersonate another user', function (
    string $method,
): void {
    $response = enterResponse(User::factory()->create()->id, $method);

    $response->assertForbidden();

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
})->with('enter-routes');

test('regular user cannot impersonate another user', function (
    string $method,
): void {
    $user = User::factory()->create();

    actingAs($user, 'web');

    $response = enterResponse($user->id, $method);

    $response->assertForbidden();

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
})->with('enter-routes');

it('cannot impersonate non-existent user', function (
    string $method,
): void {
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    $response = enterResponse(PHP_INT_MAX, $method);

    $response
        ->assertRedirect()
        ->assertSessionHasErrors([
            'id' => trans_impersonate('validation.enter.cannot_be_impersonated'),
        ]);

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
})->with('enter-routes');

it('cannot impersonate if already in impersonation mode', function (
    string $method,
): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([Settings::key() => $user->getKey()]);

    $response = enterResponse($user->id, $method);

    $response
        ->assertRedirect()
        ->assertSessionHasErrors([
            'id' => trans_impersonate('validation.enter.is_impersonating'),
        ]);
})->with('enter-routes');

it('cannot impersonate non-impersonated user', function (
    string $method,
): void {
    $user = User::factory()->notImpersonated()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());

    $response = enterResponse($user->id, $method);

    $response
        ->assertRedirect()
        ->assertSessionHasErrors([
            'id' => trans_impersonate('validation.enter.cannot_be_impersonated'),
        ]);

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
})->with('enter-routes');

test('admin cannot impersonate with no permissions', function (
    string $method,
): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());

    $response = enterResponse($user->id, $method);

    $response
        ->assertRedirect()
        ->assertSessionHasErrors([
            'id' => trans_impersonate('validation.enter.cannot_impersonate'),
        ]);

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
})->with('enter-routes');
