<?php

namespace User\Http\Requests\User\Wallet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;
use User\Models\CryptoCurrency;

class UpdateWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        $user_id = auth()->check() ? auth()->user()->id : null;
        return [
            'wallet_id' => 'required|string|exists:crypto_wallets,uuid,user_id,' . $user_id,
            'crypto_currency_id' => 'required|exists:crypto_currencies,id,is_active,1',
            'address' => "required|string|unique:crypto_wallets,address,{$this->wallet_id},uuid,user_id,{$user_id}|min:10",
            'description' => 'nullable|string',
            'is_active' => 'required|boolean'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $cryptoCurrency = CryptoCurrency::find($this->get('crypto_currency_id'));
        if($cryptoCurrency) {
            try {
                $validator->after(function($validator) use($cryptoCurrency){
                    if(!empty($this->address) AND strlen($this->address) > 10){
                        $cryptoValidator = Validation::make($cryptoCurrency->iso);
                        if(!$cryptoValidator->validate($this->address))
                            $validator->errors()->add('address', trans('user.responses.wrong-wallet-address'));
                    }
                });
            } catch (\Throwable $exception) {
                Log::error('AddWalletRequest => ' . $exception->getMessage());
                $validator->errors()->add('address', trans('user.responses.wrong-wallet-address'));
            }
        }
        return;

    }
}
