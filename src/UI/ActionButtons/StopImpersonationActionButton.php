<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ActionButtons;

use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use MoonShine\ActionButtons\ActionButton;

/**
 * Class StopImpersonationActionButton
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class StopImpersonationActionButton
{
    public static function resolve(): ActionButton
    {
        return ActionButton::make(
            label: trans_impersonate('ui.buttons.stop.label'),
            url: static fn (mixed $data): string => route_impersonate('stop'),
        )
            ->canSee(
                callback: fn (): bool => app(ImpersonateManager::class)->canStop(),
            )
            ->icon(config_impersonate('buttons.stop.icon'));
    }
}
