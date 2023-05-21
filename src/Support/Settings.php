<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Support;

/**
 * Class Settings
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class Settings
{
    public const ALIAS = 'ms-impersonate';

    /**
     * @return class-string
     */
    public static function userClass(): string
    {
        return config('auth.providers.users.model');
    }

    public static function key(): string
    {
        return config('ms-impersonate.key');
    }

    public static function defaultGuard(): string
    {
        return config('auth.defaults.guard', 'web');
    }

    public static function moonShineGuard(): string
    {
        if (config('moonshine.auth.enable', false) === false) {
            return config('auth.defaults.guard');
        }

        return config(
            'moonshine.auth.guard',
            config('auth.defaults.guard')
        );
    }

    public static function impersonatorSessionKey(): string
    {
        return 'impersonator-id';
    }

    public static function impersonatorSessionGuardKey(): string
    {
        return 'impersonator-guard';
    }
}
