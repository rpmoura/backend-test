<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'wallets';

    protected $fillable = [
        'user_id',
        'amount',
    ];
}
