<?php

namespace User\Observers;

use User\Models\CryptoWallet;

class CryptoWalletObserver
{

    public function updating(CryptoWallet $wallet)
    {
        if(auth()->check()) {
            $data = CryptoWallet::find($wallet->id);
            $attributes = array_merge($data->toArray(),[
                'actor_id' => auth()->user()->id
            ]);
            $wallet->cryptoWalletHistories()->create($attributes);

        }
    }

}
