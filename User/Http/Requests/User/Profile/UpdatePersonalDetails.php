<?php

namespace User\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use User\Models\User;

class UpdatePersonalDetails extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'nullable|in:Male,Female,Other',
            'birthday' => 'nullable|date|before:' . now() . '|date_format:Y/m/d',
        ];
    }

}
