<?php

namespace User\Http\Requests\User\Wallet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;
use User\Models\CryptoCurrency;

class AddWalletRequest extends FormRequest
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
            'crypto_currency_id' => 'required|exists:crypto_currencies,id,is_active,1',
            'address' => 'required|string|min:10|unique:crypto_wallets,address,null,null,user_id,' . $user_id,
            'description' => 'nullable|string'
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
        Log::info('Environment => ' . app()->environment());
        if(!in_array(app()->environment(),['development','staging'])) {
            $cryptoCurrency = CryptoCurrency::query()->find($this->get('crypto_currency_id'));
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
}
