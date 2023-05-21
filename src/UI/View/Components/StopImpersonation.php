<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;

/**
 * Class StopImpersonation
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class StopImpersonation extends Component
{
    public readonly string $route;

    public readonly string $label;

    public readonly string $icon;

    public readonly string $class;

    public function __construct(
        string $route = null,
        string $label = null,
        string $icon = null,
        string $class = null,
    ) {
        $this->route = $route === null ? route_impersonate('stop') : $route;
        $this->label = $label === null ? trans_impersonate('ui.buttons.stop.label') : $label;
        $this->icon = $icon === null ? config_impersonate('buttons.stop.icon') : $icon;
        $this->class = $class === null ? config_impersonate('buttons.stop.class') : $class;
    }

    public function render(): View
    {
        return view_impersonate('components.impersonate-stop');
    }

    public function shouldRender(): bool
    {
        return app(ImpersonateManager::class)->canStop();
    }
}
