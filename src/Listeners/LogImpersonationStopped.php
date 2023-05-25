<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;

/**
 * Class LogImpersonationStopped
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class LogImpersonationStopped implements ShouldQueue
{
    public function handle(ImpersonationStopped $event): void
    {
        $event->impersonated->changeLogs()->create([
            'moonshine_user_id' => $event->impersonator->getAuthIdentifier(),
            'states_before' => State::IMPERSONATION_ENTERED->value,
            'states_after' => State::IMPERSONATION_STOPPED->value,
        ]);
    }

    public function shouldQueue(ImpersonationStopped $event): bool
    {
        return method_exists($event->impersonated, 'changeLogs');
    }
}
