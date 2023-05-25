<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationStopped;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\NonLogUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

it('handles stopped impersonation mode', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    assertDatabaseEmpty('moonshine_change_logs');

    $event = new ImpersonationStopped($moonShineUser, $user);
    $listener = new LogImpersonationStopped();
    $listener->handle($event);

    assertDatabaseHas('moonshine_change_logs', [
        'moonshine_user_id' => $moonShineUser->getAuthIdentifier(),
        'changelogable_type' => $user::class,
        'changelogable_id' => $user->getKey(),
        'states_before' => '"'.State::IMPERSONATION_ENTERED->value.'"',
        'states_after' => '"'.State::IMPERSONATION_STOPPED->value.'"',
    ]);
});

it('listens stopped impersonation event', function (): void {
    Event::fake();

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([Settings::key() => $user->getKey()]);

    get(route_impersonate('stop'))
        ->assertSessionHasNoErrors();

    Event::assertListening(
        ImpersonationStopped::class,
        LogImpersonationStopped::class
    );
});

it('cannot log stopped impersonation mode without changeLogs relation', function (): void {
    config(['auth.providers.users.model' => NonLogUser::class]);

    $user = NonLogUser::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    $event = new ImpersonationStopped($moonShineUser, $user);
    $listener = new LogImpersonationStopped();

    expect($listener->shouldQueue($event))
        ->toBeFalse();
});
