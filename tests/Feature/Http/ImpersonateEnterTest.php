<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    setAuthConfig();
    enableMoonShineGuard();
});

test('privileged user can impersonate another user', function () {
    Event::fake();
    $user = User::factory()->create([
        'name' => 'user',
    ]);
    $moonShineUser = MoonshineUser::factory()->create([
        'name' => 'admin',
    ]);

    actingAs($moonShineUser, Settings::moonShineGuard());
    $response = post(route_impersonate('enter'), [
        'id' => $user->id,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $session = session();
    expect($session->get(config_impersonate('key')))
        ->toBe($user->id)
        ->and($session->get(Settings::impersonatorSessionKey()))
        ->toBe($moonShineUser->getKey())
        ->and($session->get(Settings::impersonatorSessionGuardKey()))
        ->toBe(Settings::moonShineGuard())
        ->and(auth(Settings::moonShineGuard())->user()->name)
        ->toBe($moonShineUser->name)
    ;

    Event::assertDispatched(
        fn (ImpersonationEntered $event) =>
            $event->impersonator->getAuthIdentifier() === $moonShineUser->id &&
            $event->impersonated->getAuthIdentifier() === $user->id
    );
});

test('unauthorized user cannot impersonate another user', function () {
    $response = post(route_impersonate('enter'), [
        'id' => User::factory()->create()->id,
    ]);

    $response->assertForbidden();

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
});

test('regular user cannot impersonate another user', function () {
    $user = User::factory()->create();

    actingAs($user, 'web');
    $response = post(route_impersonate('enter'), [
        'id' => $user->id,
    ]);

    $response->assertForbidden();

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
});

it('cannot impersonate non-existent user', function () {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    $response = post(route_impersonate('enter'), [
        'id' => $user->id + 1,
    ]);

    $response->assertNotFound();

    expect(session()->get(config_impersonate('key')))
        ->toBeEmpty()
    ;
});

it('cannot impersonate if already in impersonation mode', function () {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([Settings::key() => $user->getKey()]);

    $response = post(route_impersonate('enter'), [
        'id' => $user->id,
    ]);

    $response->assertSessionHasErrors([
        'id' => trans_impersonate('validation.enter.is_impersonating'),
    ]);
});
