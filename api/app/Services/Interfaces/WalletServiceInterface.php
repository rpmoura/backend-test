<?php

namespace App\Services\Interfaces;

use App\Models\User;
use App\Models\Wallet;

interface WalletServiceInterface
{
    public function create(User $user, float $amount = 0): Wallet;

    public function findByOwner(User $owner);

    public function completeTransfer(array $attributes);
}
