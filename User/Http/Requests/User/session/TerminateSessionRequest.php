<?php

namespace User\Http\Requests\User\Session;

use Illuminate\Foundation\Http\FormRequest;

class TerminateSessionRequest extends FormRequest
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
            'session_id' => 'required|exists:agents,id,token_id,!null,user_id,' . request()->user()->id ,
        ];
    }
}
