<?php

use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Jampire\MoonshineImpersonate\UI\Components\StopImpersonation;

use function Pest\Laravel\actingAs;

uses()->group('ui');

it('correctly renders stop button with defaults', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([config_impersonate('key') => 1]);

    $view = $this->component(StopImpersonation::class);

    $view
        ->assertSee(trans_impersonate('ui.buttons.stop.label'))
        ->assertSee(route_impersonate('stop'))
        ->assertSee(config_impersonate('buttons.stop.class'));
});

it('correctly renders stop button', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([config_impersonate('key') => 1]);

    $view = $this->component(StopImpersonation::class, [
        'label' => 'Label',
        'class' => 'btn-red',
    ]);

    $view
        ->assertSee('Label')
        ->assertSee(route_impersonate('stop'))
        ->assertSee('btn-red');
});

it('does not render stop button without permissions', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();
    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([config_impersonate('key') => $user->id]);

    $view = $this->component(StopImpersonation::class);

    $view
        ->assertDontSee(trans_impersonate('ui.buttons.stop.label'))
        ->assertDontSee(route_impersonate('stop'))
        ->assertDontSee(config_impersonate('buttons.stop.class'));
});

it('does not render stop button when no one is impersonated', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $view = $this->component(StopImpersonation::class);

    $view
        ->assertDontSee(trans_impersonate('ui.buttons.stop.label'))
        ->assertDontSee(route_impersonate('stop'))
        ->assertDontSee(config_impersonate('buttons.stop.class'));
});
