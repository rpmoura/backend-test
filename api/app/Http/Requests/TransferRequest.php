<?php

namespace App\Http\Requests;

class TransferRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'transfer.payee'  => ['required'],
            'transfer.amount' => ['required', 'numeric', 'gt:0'],
        ];
    }

    public function attributes()
    {
        return [
            'transfer.payee'  => 'beneficiário',
            'transfer.amount' => 'valor',
        ];
    }
}
