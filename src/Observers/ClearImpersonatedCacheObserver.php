<?php

namespace Jampire\MoonshineImpersonate\Observers;

use Illuminate\Support\Facades\Cache;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Models\MoonshineChangeLog;

class ClearImpersonatedCacheObserver
{
    public function created(MoonshineChangeLog $changeLog): void
    {
        if ($changeLog->changelogable_type === Settings::userClass() &&
            $changeLog->states_before === State::IMPERSONATION_STOPPED->value &&
            $changeLog->states_after === State::IMPERSONATION_ENTERED->value
        ) {

            $key = [
                'impersonated',
                $changeLog->changelogable_id,
                State::IMPERSONATION_ENTERED->value,
            ];
            Cache::forget(implode('::', $key));
        }
    }
}
