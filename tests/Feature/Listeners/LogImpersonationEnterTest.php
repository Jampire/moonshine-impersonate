<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationEnter;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\NonLogUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('handles enter impersonation mode', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    assertDatabaseEmpty('moonshine_change_logs');

    $event = new ImpersonationEntered($moonShineUser, $user);
    $listener = new LogImpersonationEnter();
    $listener->handle($event);

    assertDatabaseHas('moonshine_change_logs', [
        'moonshine_user_id' => $moonShineUser->getAuthIdentifier(),
        'changelogable_type' => $user::class,
        'changelogable_id' => $user->getKey(),
        'states_before' => '"'.State::IMPERSONATION_STOPPED->value.'"',
        'states_after' => '"'.State::IMPERSONATION_ENTERED->value.'"',
    ]);
});

it('listens enter impersonation event', function (): void {
    Event::fake();

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    post(route_impersonate('enter'), [
        'id' => $user->id,
    ])->assertSessionHasNoErrors();

    Event::assertListening(
        ImpersonationEntered::class,
        LogImpersonationEnter::class
    );
});

it('cannot log enter impersonation mode without changeLogs relation', function (): void {
    config(['auth.providers.users.model' => NonLogUser::class]);

    $user = NonLogUser::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    $event = new ImpersonationEntered($moonShineUser, $user);
    $listener = new LogImpersonationEnter();

    expect($listener->shouldQueue($event))
        ->toBeFalse();
});
