<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\Components;

use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Components\MoonShineComponent;

/**
 * Class StopImpersonation
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @method static static make(string $route = null, string $label = null, string $icon = null, string $class = null)
 */
final class StopImpersonation extends MoonShineComponent
{
    public function __construct(
        private readonly ?string $route = null,
        private readonly ?string $label = null,
        private readonly ?string $icon = null,
        private readonly ?string $class = null,
    ) {
        //
    }

    public function getView(): string
    {
        return $this->customView ?? Settings::ALIAS.'::components.impersonate-stop';
    }

    /**
     * @return array{canStop: bool, route: string, label: string, icon: string, class: string}
     */
    protected function viewData(): array
    {
        return [
            'canStop' => app(ImpersonateManager::class)->canStop(),
            'route' => $this->route ?? route_impersonate('stop'),
            'label' => $this->label ?? trans_impersonate('ui.buttons.stop.label'),
            'icon' => $this->icon ?? config_impersonate('buttons.stop.icon'),
            'class' => $this->class ?? config_impersonate('buttons.stop.class'),
        ];
    }
}
