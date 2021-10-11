<?php

namespace User\Http\Controllers\Admin;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use User\Http\Requests\Admin\MemberIdRequest;
use User\Http\Requests\Admin\AddWalletRequest;
use User\Http\Requests\Admin\UpdateWalletRequest;
use User\Http\Resources\User\WalletResource;
use User\Models\User;

class WalletController extends Controller
{

    /**
     * Get All Wallets list
     * @group Admin User > User Wallets
     * @param MemberIdRequest $request
     * @return JsonResponse
     */
    public function index(MemberIdRequest $request)
    {
        $list = User::query()->whereMemberId($request->get('member_id'))->first()->wallets()->paginate();
        return api()->success(trans('user.responses.ok'),[
            'list' => WalletResource::collection($list),
            'pagination' => [
                'total' => $list->total(),
                'per_page' => $list->perPage()
            ]
        ]);
    }

    /**
     * Get All Active wallets
     * @group Admin User > User Wallets
     * @param MemberIdRequest $request
     * @return JsonResponse
     */
    public function activeWallets(MemberIdRequest $request)
    {
        $list = User::query()->whereMemberId($request->get('member_id'))->wallets()->active()->paginate();

        return api()->success(trans('user.responses.ok'),[
            'list' => WalletResource::collection($list),
            'pagination' => [
                'total' => $list->total(),
                'per_page' => $list->perPage()
            ]
        ]);
    }

    /**
     * Get All Inactive wallets
     * @group Admin User > User Wallets
     * @param MemberIdRequest $request
     * @return JsonResponse
     */
    public function inactiveWallets(MemberIdRequest $request)
    {
        $list = User::query()->whereMemberId($request->get('member_id'))->wallets()->inactive()->paginate();

        return api()->success(trans('user.responses.ok'),[
            'list' => WalletResource::collection($list),
            'pagination' => [
                'total' => $list->total(),
                'per_page' => $list->perPage()
            ]
        ]);
    }

    /**
     * Add new wallet address
     * @group Admin User > User Wallets
     * @param AddWalletRequest $request
     * @return JsonResponse
     */
    public function add(AddWalletRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = User::query()->whereMemberId($request->get('member_id'))->first();
            $wallet = $user->wallets()->create([
                'crypto_currency_id' => $request->get('crypto_currency_id'),
                'address' => $request->get('address')
            ]);

            DB::commit();

            return api()->success(trans('user.responses.ok'), WalletResource::make($wallet));

        }catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }

    /**
     * Update Wallet
     * @group Admin User > User Wallets
     * @param UpdateWalletRequest $request
     * @return JsonResponse
     */
    public function updateWallet(UpdateWalletRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = User::query()->whereMemberId($request->get('member_id'))->first();
            $wallet = $user->wallets()->where('uuid',$request->get('wallet_id'))->first();
            $wallet->update($request->validated());

            DB::commit();

            return api()->success(trans('user.responses.wallet-updated', ['currency' => $wallet->cryptoCurrency->name]));

        }catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }
}
