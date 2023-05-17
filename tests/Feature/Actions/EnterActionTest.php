<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    setAuthConfig();
    enableMoonShineGuard();
});

it('cannot execute enter action if user does not found', function () {
    $moonShineUser = MoonshineUser::factory()->create();
    actingAs($moonShineUser, Settings::moonShineGuard());

    $action = new EnterAction(app(ImpersonateManager::class));

    expect($action->execute(123))
        ->toBeFalse();
});
