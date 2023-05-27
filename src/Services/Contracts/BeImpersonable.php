<?php

namespace Jampire\MoonshineImpersonate\Services\Contracts;

/**
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
interface BeImpersonable
{
    /**
     * True if user can be impersonated, false otherwise
     */
    public function canBeImpersonated(): bool;
}
