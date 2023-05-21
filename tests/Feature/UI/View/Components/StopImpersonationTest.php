<?php

use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\UI\View\Components\StopImpersonation;

use function Pest\Laravel\actingAs;

it('correctly renders stop button with defaults', function () {
    $view = $this->component(StopImpersonation::class);

    $view->assertSee(
        trans_impersonate('ui.buttons.stop.label')
    );
    $view->assertSee(
        route_impersonate('stop')
    );
    $view->assertSee(
        config_impersonate('buttons.stop.class')
    );
});

it('correctly renders stop button', function () {
    $view = $this->component(StopImpersonation::class, [
        'label' => 'Label',
        'class' => 'btn-red',
    ]);

    $view->assertSee('Label');
    $view->assertSee(route_impersonate('stop'));
    $view->assertSee('btn-red');
});

it('renders with permission', function () {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard())
        ->withSession([config_impersonate('key') => 1]);

    $component = new StopImpersonation();

    expect($component->shouldRender())
        ->toBeTrue()
    ;
});

it('does not render when there is no permission', function () {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $component = new StopImpersonation();

    expect($component->shouldRender())
        ->toBeFalse()
    ;
});
