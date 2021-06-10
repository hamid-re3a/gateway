<?php

namespace R2FUser\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:4', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'last_name' => ['required', 'string', 'min:4', 'max:255', 'regex:/^[a-zA-Z ]*$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'username' => ['required', 'unique:users', 'regex:/^[a-z][a-z0-9_]{2,}$/'],
            'password' => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ];
    }
}
