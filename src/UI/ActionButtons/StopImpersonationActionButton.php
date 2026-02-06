<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ActionButtons;

use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\UI\ActionButtons\Contracts\Resolvable;
use MoonShine\UI\Components\ActionButton;

/**
 * Class StopImpersonationActionButton
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class StopImpersonationActionButton implements Resolvable
{
    public static function resolve(): ActionButton
    {
        return ActionButton::make(
            label: trans_impersonate('ui.buttons.stop.label'),
            url: route_impersonate('stop'),
        )
            ->canSee(
                callback: fn (): bool => app(ImpersonateManager::class)->canStop(),
            )
            ->icon(config_impersonate('buttons.stop.icon'));
    }
}
