<?php

declare(strict_types=1);

arch('Strict Types')
    ->expect('Jampire\MoonshineImpersonate')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch('Final Classes')
    ->expect('Jampire\MoonshineImpersonate')
    ->classes()
    ->toBeFinal()
    ->ignoring('Jampire\MoonshineImpersonate\Http\Controllers\Controller');

arch('HTTP')
    ->expect('Jampire\MoonshineImpersonate\Http')
    ->toOnlyBeUsedIn('Jampire\MoonshineImpersonate\Http')
    ->ignoring('Jampire\MoonshineImpersonate\Http\Middleware');

arch('Enums')
    ->expect('Jampire\MoonshineImpersonate\Enums')
    ->toBeEnums();

arch('Actions')
    ->expect('Jampire\MoonshineImpersonate\Actions')
    ->toImplement('Jampire\MoonshineImpersonate\Actions\Contracts\Actionable');
