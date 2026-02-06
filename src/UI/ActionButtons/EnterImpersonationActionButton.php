<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ActionButtons;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\UI\ActionButtons\Contracts\Resolvable;
use MoonShine\UI\Components\ActionButton;

/**
 * Class EnterImpersonationActionButton
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class EnterImpersonationActionButton implements Resolvable
{
    public static function resolve(): ActionButton
    {
        return ActionButton::make(
            label: trans_impersonate('ui.buttons.enter.label'),
            url: static fn (Model $item): string => route_impersonate('enter', [
                config_impersonate('resource_item_key') => $item->getKey(),
            ]),
        )
            ->canSee(
                callback: fn (Authenticatable $item): bool => app(ImpersonateManager::class)->canEnter($item),
            )
            ->icon(config_impersonate('buttons.enter.icon'));
    }
}
