<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\ItemActions;

use Illuminate\Contracts\Auth\Authenticatable;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use MoonShine\Contracts\Actions\ItemActionContact;
use MoonShine\ItemActions\ItemAction;
use MoonShine\Traits\Makeable;

/**
 * Class EnterImpersonationItemAction
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class EnterImpersonationItemAction implements ItemActionContact
{
    use Makeable;

    public function resolve(): ItemAction
    {
        $action = app(EnterAction::class);

        return ItemAction::make(
            __('ms-impersonate::ui.buttons.enter.label'),
            fn (Authenticatable $item) => $action->execute($item->getAuthIdentifier(), true),
            __('ms-impersonate::ui.buttons.enter.message') // TODO: set message from $action->execute
        )
            ->canSee(fn (Authenticatable $item) => $action->manager->canEnter($item))
            ->icon(config('ms-impersonate.buttons.enter.icon'))
        ;
    }
}
