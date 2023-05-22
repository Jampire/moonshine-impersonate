<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function (): void {
    setAuthConfig();
    enableMoonShineGuard();
});

test('privileged user can stop impersonation', function (): void {
    Event::fake();
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    post(route_impersonate('enter'), [
        'id' => $user->id,
    ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $response = get(route_impersonate('stop'));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $session = session();
    expect($session->get(config_impersonate('key')))
        ->toBeEmpty()
        ->and($session->get(Settings::impersonatorSessionKey()))
        ->toBeEmpty()
        ->and($session->get(Settings::impersonatorSessionGuardKey()))
        ->toBeEmpty()
        ->and(auth()->user())
        ->toBeEmpty()
    ;

    Event::assertDispatched(
        fn (ImpersonationStopped $event): bool =>
            $event->impersonator->getAuthIdentifier() === $moonShineUser->id &&
            $event->impersonated->getAuthIdentifier() === $user->id
    );
});

test('unauthorized user cannot stop impersonation', function (): void {
    get(route_impersonate('stop'))
        ->assertForbidden();
});

test('regular user cannot stop impersonation', function (): void {
    actingAs(User::factory()->create(), 'web');

    get(route_impersonate('stop'))
        ->assertForbidden();
});

it('cannot stop impersonation if impersonation mode is not enabled', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    $response = get(route_impersonate('stop'));

    $response->assertSessionHasErrors([
        Settings::key() => trans_impersonate('validation.stop.is_not_impersonating'),
    ]);
});
