<?php

namespace User\Http\Controllers\Front;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use User\Http\Requests\User\Profile\ChangeTransactionPasswordRequest;
use User\Jobs\EmailJob;
use User\Mail\User\ProfileManagement\TransactionPasswordChangedEmail;
use User\Support\UserActivityHelper;

class UserController extends Controller
{
    /**
     * Change Transaction password
     * @group
     * Profile Management
     * @param ChangeTransactionPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeTransactionPassword(ChangeTransactionPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->user()->update([
                'transaction_password' => $request->get('password') //bcrypt in User model (Mutator)
            ]);

            list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
            if(getSetting('IS_TRANSACTION_PASSWORD_CHANGE_EMAIL_ENABLE'))
                EmailJob::dispatch(new TransactionPasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

            DB::commit();
            return api()->success(trans('user.responses.transaction-password-successfully-changed'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }
}
