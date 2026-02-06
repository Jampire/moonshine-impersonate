<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Http\Middleware;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class ImpersonateMiddleware
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class ImpersonateMiddleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        if (!Auth::guard(Settings::moonShineGuard())->user() || !$request->hasSession()) {
            return $next($request);
        }

        $session = $request->session();
        $key = Settings::key();

        if (!$session->has($key) || empty($session->get($key))) {
            return $next($request);
        }

        $user = app(ImpersonateManager::class)->getUserFromSession();

        if (!$user instanceof Authenticatable) {
            // @codeCoverageIgnoreStart
            return $next($request);
            // @codeCoverageIgnoreEnd
        }

        // @phpstan-ignore-next-line
        Auth::guard(Settings::defaultGuard())->quietLogin($user);

        return $next($request);
    }
}
