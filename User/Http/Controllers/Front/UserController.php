<?php

namespace User\Http\Controllers\Front;


use Illuminate\Routing\Controller;
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
        $request->user()->update([
            'transaction_password' => bcrypt($request->get('password'))
        ]);

        list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
        EmailJob::dispatch(new TransactionPasswordChangedEmail($request->user(), $ip_db, $agent_db), $request->user()->email);

        return api()->success();
    }
}
