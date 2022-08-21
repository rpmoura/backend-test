<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'       => $this->uuid,
            'amount'     => $this->amount,
            'updated_at' => $this->updated_at,
        ];
    }
}
