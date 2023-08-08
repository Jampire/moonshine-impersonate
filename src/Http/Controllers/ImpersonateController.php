<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Actions\StopAction;
use Jampire\MoonshineImpersonate\Http\Requests\EnterFormRequest;
use Jampire\MoonshineImpersonate\Http\Requests\StopFormRequest;

/**
 * Class ImpersonateController
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonateController extends Controller
{
    public function enter(EnterFormRequest $request, EnterAction $action): Redirector|RedirectResponse
    {
        $action->execute($request->safe()->id);

        // TODO: flash message if execution failed

        return (
        empty(config_impersonate('redirect_to')) ?
            redirect()->back() :
            redirect(config_impersonate('redirect_to'))
        );
    }

    public function stop(StopFormRequest $request, StopAction $action): Redirector|RedirectResponse
    {
        $action->execute();

        // TODO: flash message if execution failed

        return (
            empty(config_impersonate('redirect_to')) ?
                redirect()->back() :
                redirect(config_impersonate('redirect_to'))
        );
    }
}
