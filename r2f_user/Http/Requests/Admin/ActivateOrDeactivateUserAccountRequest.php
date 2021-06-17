<?php

namespace R2FUser\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivateOrDeactivateUserAccountRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'deactivate' => 'nullable|boolean'
        ];
    }
}
