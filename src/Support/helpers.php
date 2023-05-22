<?php

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Jampire\MoonshineImpersonate\Support\Settings;

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
     * @param string|null $locale
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function trans_impersonate(string $key, array $replace = [], string $locale = null): string
    {
        return __(Settings::ALIAS.'::'.$key, $replace, $locale);
    }
}

if (!function_exists('view_impersonate')) {
    /**
     * @param string $key Translation key without namespace
     * @param mixed[]|Arrayable $data
     * @param mixed[] $mergeData
     * @author Dzianis Kotau <me@dzianiskotau.com>
     */
    function view_impersonate(string $key, array|Arrayable $data = [], array $mergeData = []): View
    {
        return view(Settings::ALIAS.'::'.$key, $data, $mergeData);
    }
}
