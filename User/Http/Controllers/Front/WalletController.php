<?php

namespace User\Http\Controllers\Front;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use User\Http\Requests\User\Wallet\AddWalletRequest;
use User\Http\Requests\User\Wallet\UpdateWalletRequest;
use User\Http\Resources\User\CryptoCurrencyResource;
use User\Http\Resources\User\WalletResource;
use User\Models\CryptoCurrency;

class WalletController extends Controller
{
    /**
     * Get All Crypto currencies list
     * @group Public User > Wallets
     */
    public function availableCryptoCurrencies()
    {
        return api()->success(trans('user.responses.ok'),CryptoCurrencyResource::collection(CryptoCurrency::active()->get()));
    }

    /**
     * Get All Wallets list
     * @group Public User > Wallets
     */
    public function index()
    {
        return api()->success(trans('user.responses.ok'),WalletResource::collection(auth()->user()->wallets()->simplePaginate()));
    }

    /**
     * Get All Active wallets
     * @group Public User > Wallets
     */
    public function activeWallets()
    {
        return api()->success(trans('user.responses.ok'),WalletResource::collection(auth()->user()->wallets()->active()->simplePaginate()));
    }

    /**
     * Get All Inactive wallets
     * @group Public User > Wallets
     */
    public function inactiveWallets()
    {
        return api()->success(trans('user.responses.ok'),WalletResource::collection(auth()->user()->wallets()->inactive()->simplePaginate()));
    }

    /**
     * Add new wallet address
     * @group Public User > Wallets
     * @param AddWalletRequest $request
     * @return JsonResponse
     */
    public function add(AddWalletRequest $request)
    {
        try{
            DB::beginTransaction();
            $wallet = auth()->user()->wallets()->create([
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
     * @group Public User > Wallets
     * @param UpdateWalletRequest $request
     * @return JsonResponse
     */
    public function updateWallet(UpdateWalletRequest $request)
    {
        try{
            DB::beginTransaction();
            $wallet = auth()->user()->wallets()->where('uuid',$request->get('wallet_id'))->first();
            $wallet->update($request->validated());

            DB::commit();

            return api()->success(trans('user.responses.wallet-updated', ['currency' => $wallet->cryptoCurrency->name]));

        }catch (\Throwable $exception) {
            DB::rollBack();
            return api()->error(trans('user.responses.global-error'));
        }
    }
}
