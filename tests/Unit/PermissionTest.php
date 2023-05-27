<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;

it('can impersonate', function (): void {
    $moonShineUser = MoonshineUser::factory()->create();

    $manager = new ImpersonateManager($moonShineUser);

    expect($manager->canImpersonate())
        ->toBeTrue()
    ;
});

it('can be impersonated', function (): void {
    $user = User::factory()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    $manager = new ImpersonateManager($moonShineUser);

    expect($manager->canBeImpersonated($user))
        ->toBeTrue()
    ;
});

it('cannot impersonate with no permissions', function (): void {
    $moonShineUser = MoonshineUser::factory()->cannotImpersonate()->create();

    $manager = new ImpersonateManager($moonShineUser);

    expect($manager->canImpersonate())
        ->toBeFalse()
    ;
});

it('cannot be impersonated with no permissions', function (): void {
    $user = User::factory()->notImpersonated()->create();
    $moonShineUser = MoonshineUser::factory()->create();

    $manager = new ImpersonateManager($moonShineUser);

    expect($manager->canBeImpersonated($user))
        ->toBeFalse()
    ;
});
