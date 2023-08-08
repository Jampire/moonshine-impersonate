<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;

/**
 * Class ClearImpersonatedCache
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ClearImpersonatedCache implements ShouldQueue
{
    public function handle(ImpersonationEntered $event): void
    {
        $key = [
            'impersonated',
            $event->impersonated->getAuthIdentifier(),
            State::IMPERSONATION_ENTERED->value,
        ];
        Cache::forget(implode('::', $key));
    }
}
