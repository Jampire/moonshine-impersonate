<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ActionButtons\Contracts;

use MoonShine\UI\Components\ActionButton;

interface Resolvable
{
    public static function resolve(): ActionButton;
}
