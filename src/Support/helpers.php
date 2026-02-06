<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Support\Enums\ToastType;

if (!function_exists('route_impersonate')) {
    /**
     * @param string $routeName Route name without prefix
     * @param mixed[] $parameters
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function route_impersonate(string $routeName, array $parameters = [], bool $absolute = true): string
    {
        return route(Settings::ALIAS.'.'.$routeName, $parameters, $absolute);
    }
}

if (!function_exists('config_impersonate')) {
    /**
     * @param string $key Config key without prefix
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function config_impersonate(string $key, mixed $default = null): mixed
    {
        return config(Settings::ALIAS.'.'.$key, $default);
    }
}

if (!function_exists('trans_impersonate')) {
    /**
     * @param string $key Translation key without namespace
     * @param mixed[] $replace
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function trans_impersonate(string $key, array $replace = [], ?string $locale = null): string
    {
        return __(Settings::ALIAS.'::'.$key, $replace, $locale);
    }
}

if (!function_exists('toast_if')) {
    /**
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function toast_if(bool $condition, string $message, ToastType $type = ToastType::INFO): void
    {
        if (!$condition) {
            return;
        }

        toast(message: $message, type: $type);
    }
}

if (!function_exists('toast_error_if')) {
    /**
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function toast_error_if(bool $condition, string $message): void
    {
        toast_if($condition, $message, ToastType::ERROR);
    }
}

if (!function_exists('toast_success_if')) {
    /**
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function toast_success_if(bool $condition, string $message): void
    {
        toast_if($condition, $message, ToastType::SUCCESS);
    }
}
