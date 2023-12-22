<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ActionButtons;

use Illuminate\Contracts\Auth\Authenticatable;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use MoonShine\ActionButtons\ActionButton;

/**
 * Class EnterImpersonationActionButton
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class EnterImpersonationActionButton
{
    public static function resolve(): ActionButton
    {
        return ActionButton::make(
            label: trans_impersonate('ui.buttons.enter.label'),
            url: static fn (mixed $data): string => route_impersonate('enter', [
                config_impersonate('resource_item_key') => $data->getKey(),
            ]),
        )
            ->canSee(
                callback: fn (Authenticatable $item): bool => app(ImpersonateManager::class)->canEnter($item),
            )
            ->icon(config_impersonate('buttons.enter.icon'));
    }
}
