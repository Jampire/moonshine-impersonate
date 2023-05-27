<?php

namespace Jampire\MoonshineImpersonate\Services\Contracts;

/**
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
interface Impersonable
{
    /**
     * True if user can impersonate, false otherwise
     */
    public function canImpersonate(): bool;
}
