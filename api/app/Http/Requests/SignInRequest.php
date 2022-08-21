<?php

namespace App\Http\Requests;

class SignInRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'credential' => 'required',
            'password'   => 'required',
        ];
    }
}
