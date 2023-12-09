<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Exceptions\IsNotLoggableException;
use Jampire\MoonshineImpersonate\Models\ImpersonatedAudit;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Models\MoonshineChangeLog;
use MoonShine\Models\MoonshineUser;

/**
 * Class ImpersonatedAggregationService
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonatedAggregationService
{
    private int $count = 0;

    private ?string $lastImpersonatorName = null;

    private ?Carbon $lastImpersonatedAt = null;

    /**
     * @throws IsNotLoggableException
     */
    public function __construct(private readonly Authenticatable $impersonated)
    {
        if (!Settings::isImpersonationLoggable()) {
            throw IsNotLoggableException::userIsNotLoggable($this->impersonated);
        }

        $this->setData();
    }

    /**
     * @throws IsNotLoggableException
     */
    public static function count(Authenticatable $impersonated): int
    {
        return (new self($impersonated))->getCount();
    }

    /**
     * @throws IsNotLoggableException
     */
    public static function lastImpersonatedBy(Authenticatable $impersonated): ?string
    {
        return (new self($impersonated))->getLastImpersonatorName();
    }

    /**
     * @throws IsNotLoggableException
     */
    public static function lastImpersonatedAt(Authenticatable $impersonated): ?Carbon
    {
        return (new self($impersonated))->getLastImpersonatedAt();
    }

    public static function countUsers(): int
    {
        $key = [
            'impersonated',
            'countUsers',
            State::IMPERSONATION_ENTERED->value,
        ];

        return Cache::rememberForever(implode('::', $key), function () {
            return ImpersonatedAudit::count();

//            return MoonshineChangeLog::query()
//                ->select('changelogable_id')
//                ->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
//                ->where('states_after', '"'.State::IMPERSONATION_ENTERED->value.'"')
//                ->groupBy('changelogable_id')
//                ->get()
//                ->count();
        });
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getLastImpersonatorName(): ?string
    {
        return $this->lastImpersonatorName;
    }

    public function getLastImpersonatedAt(): ?Carbon
    {
        return $this->lastImpersonatedAt;
    }

    private function setData(): void
    {
        $key = [
            'impersonated',
            $this->impersonated->getAuthIdentifier(),
            State::IMPERSONATION_ENTERED->value,
        ];
        [$this->count, $this->lastImpersonatorName, $this->lastImpersonatedAt] =
            Cache::rememberForever(implode('::', $key), function () {
                $audit = ImpersonatedAudit::query()
                    ->where('user_id', $this->impersonated->getAuthIdentifier())
                    ->first();
                if ($audit === null) {
                    return [0, null, null];
                }

                return [
                    $audit->counter,
                    MoonshineUser::find($audit->moonshine_user_id)->name,
                    $audit->updated_at,
                ];

//                $logs = $this->impersonated->changeLogs()
//                    ->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
//                    ->where('states_after', '"'.State::IMPERSONATION_ENTERED->value.'"')
////                    ->latest()
//                    ->get();
//
//                $count = $logs->count();
//                if ($count === 0) {
//                    return [0, null, null];
//                }
//
//                $first = $logs->first();
//
//                return [
//                    $count,
//                    MoonshineUser::find($first->moonshine_user_id)->name,
//                    $first->created_at,
//                ];
            });
    }
}
