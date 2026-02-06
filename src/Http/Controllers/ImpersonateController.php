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
final class ImpersonateController extends Controller
{
    public function enter(EnterFormRequest $request, EnterAction $action): Redirector|RedirectResponse
    {
        // @phpstan-ignore-next-line
        $id = $request->safe()->id;
        $result = $action->execute(id: $id, shouldValidate: false);

        if (!$result) {
            // @codeCoverageIgnoreStart
            toast_error_if(
                condition: config_impersonate('show_notification'),
                message: trans_impersonate('validation.enter.cannot_be_impersonated'),
            );

            // @phpstan-ignore-next-line
            return redirect()->back();
            // @codeCoverageIgnoreEnd
        }

        toast_success_if(
            condition: config_impersonate('show_notification'),
            message: trans_impersonate('ui.buttons.enter.message'),
        );

        return redirect(config_impersonate('redirect_to.enter'));
    }

    public function stop(StopFormRequest $request, StopAction $action): Redirector|RedirectResponse
    {
        $result = $action->execute();

        if (!$result) {
            // @codeCoverageIgnoreStart
            toast_error_if(
                condition: config_impersonate('show_notification'),
                message: trans_impersonate('validation.stop.is_not_impersonating'),
            );

            // @phpstan-ignore-next-line
            return redirect()->back();
            // @codeCoverageIgnoreEnd
        }

        toast_success_if(
            condition: config_impersonate('show_notification'),
            message: trans_impersonate('ui.buttons.stop.message'),
        );

        return redirect(config_impersonate('redirect_to.stop'));
    }
}
