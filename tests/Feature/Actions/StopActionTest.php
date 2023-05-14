<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Actions\StopAction;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    setAuthConfig();
    enableMoonShineGuard();
});

it('cannot execute stop action if user does not found', function () {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = new StopAction(app(ImpersonateManager::class));

    expect($action->execute())
        ->toBeFalse();
});
