<?php

namespace ApiGatewayUser\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UsernameExistenceRequest extends FormRequest
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

    public function rules()
    {
        return [
            /** username can contain alphabet, underline and digits */
            'username' => ['required', 'regex:/^[a-z][a-z0-9_]{2,}$/'],
        ];
    }

}
