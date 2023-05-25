<?php

namespace Jampire\MoonshineImpersonate\Enums;

/**
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
enum State: string
{
    case IMPERSONATION_ENTERED = 'impersonation_entered';
    case IMPERSONATION_STOPPED = 'impersonation_stopped';
}
