<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'transfers';

    public function payerWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer_wallet_id', 'id');
    }

    public function payeeWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee_wallet_id', 'id');
    }
}
