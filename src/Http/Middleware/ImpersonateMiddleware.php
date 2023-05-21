<?php

namespace Jampire\MoonshineImpersonate\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class ImpersonateMiddleware
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonateMiddleware
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
        Auth::guard(Settings::defaultGuard())->quietLogin($user);

        return $next($request);
    }
}
