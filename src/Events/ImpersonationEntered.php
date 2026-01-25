<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ImpersonationEntered
 *
 * @todo ShouldQueue?
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class ImpersonationEntered
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly Authenticatable $impersonator,
        public readonly Authenticatable $impersonated,
    ) {
        //
    }
}
