<?php

namespace User\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangeTransactionPasswordRequest extends FormRequest
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
        return [
            'current_password' => 'required',
            'password' => 'required|regex:/' . getSetting('USER_REGISTRATION_PASSWORD_CRITERIA') . '/|confirmed',
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
        $validator->after(function ($validator) {
            if ( !Hash::check($this->current_password, $this->user()->password) ) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });
        return;
    }
}
