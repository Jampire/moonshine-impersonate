<?php

declare(strict_types=1);

uses()->group('arch', 'strict');

arch('strict')
    ->expect('Jampire\MoonshineImpersonate')
    ->toUseStrictTypes()
;
