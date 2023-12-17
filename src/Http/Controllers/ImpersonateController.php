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
        $result = $action->execute(id: $request->safe()->id, shouldValidate: false);

        if (!$result) {
            // @codeCoverageIgnoreStart
            toast_if(
                condition: config_impersonate('show_notification'),
                message: trans_impersonate('validation.enter.cannot_be_impersonated'),
                type: 'error'
            );

            return redirect()->back();
            // @codeCoverageIgnoreEnd
        }

        toast_if(
            condition: config_impersonate('show_notification'),
            message: trans_impersonate('ui.buttons.enter.message'),
            type: 'success'
        );

        return redirect(config_impersonate('redirect_to'));
    }

    public function stop(StopFormRequest $request, StopAction $action): Redirector|RedirectResponse
    {
        $result = $action->execute();

        if (!$result) {
            // @codeCoverageIgnoreStart
            toast_if(
                condition: config_impersonate('show_notification'),
                message: trans_impersonate('validation.stop.is_not_impersonating'),
                type: 'error'
            );

            return redirect()->back();
            // @codeCoverageIgnoreEnd
        }

        toast_if(
            condition: config_impersonate('show_notification'),
            message: trans_impersonate('ui.buttons.stop.message'),
            type: 'success'
        );

        return redirect(config_impersonate('redirect_to'));
    }
}
