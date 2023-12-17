<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses()->group('http');

beforeEach(function (): void {
    setAuthConfig();
    enableMoonShineGuard();
    registerHomePage();
});

it('authorizes impersonator as impersonated user', function (): void {
    $name = 'John Doe';
    $user = User::factory()->create([
        'name' => $name,
    ]);
    $moonShineUser = MoonshineUser::factory()->create();

    $response = get(route('test.me'));

    $response->assertOk();

    expect($response->content())
        ->toBe('Not authorized')
    ;

    actingAs($moonShineUser, Settings::moonShineGuard());
    get(route_impersonate('enter', [
        config_impersonate('resource_item_key') => $user->id,
    ]))
        ->assertSessionHasNoErrors();

    $response = get(route('test.me'));

    $response->assertOk();

    expect($response->content())
        ->toBe($name)
    ;
});

it('cannot impersonate when admin is not authorized', function (): void {
    Event::fake();

    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    actingAs($moonShineUser, Settings::moonShineGuard());
    get(route_impersonate('enter', [
        config_impersonate('resource_item_key') => $user->id,
    ]))
        ->assertSessionHasNoErrors();

    Auth::logout();

    expect(session()->get(Settings::key()))
        ->toBe($user->getKey());

    $response = get(route('test.me'));

    $response->assertOk();

    expect($response->content())
        ->toBe('Not authorized')
    ;
});
