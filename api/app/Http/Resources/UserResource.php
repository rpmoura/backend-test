<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid'       => $this->uuid,
            'name'       => $this->name,
            'email'      => $this->email,
            'cpf_cnpj'   => $this->cpf_cnpj,
            'type'       => $this->type,
            'created_at' => $this->created_at
        ];
    }
}
