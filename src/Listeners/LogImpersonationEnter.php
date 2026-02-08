<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;

/**
 * Class LogImpersonationEnter
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class LogImpersonationEnter implements ShouldQueue
{
    public function handle(ImpersonationEntered $event): void
    {
        $event->impersonated->changeLogs()->create([ // @phpstan-ignore-line
            'moonshine_user_id' => $event->impersonator->getAuthIdentifier(),
            'states_before' => State::IMPERSONATION_STOPPED->value,
            'states_after' => State::IMPERSONATION_ENTERED->value,
        ]);
    }

    public function shouldQueue(ImpersonationEntered $event): bool
    {
        return method_exists($event->impersonated, 'changeLogs');
    }
}
