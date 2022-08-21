<?php

namespace App\Http\Requests;

use App\Enums\UserTypeEnum;
use Illuminate\Validation\Rule;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class UserRequest extends RequestAbstract
{
    public function rules()
    {
        return [
            'user.name'                  => 'required',
            'user.cpf_cnpj'              => ['required', Rule::unique('users', 'cpf_cnpj')],
            'user.email'                 => ['required', Rule::unique('users', 'email')],
            'user.type'                  => ['required', Rule::in(UserTypeEnum::toArray())],
            'user.password'              => ['required', 'confirmed'],
            'user.password_confirmation' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'user.name'     => 'nome',
            'user.cpf_cnpj' => 'CPF/CNPJ',
            'user.email'    => 'e-mail',
            'user.type'     => 'tipo',
            'user.password' => 'senha',
        ];
    }
}
