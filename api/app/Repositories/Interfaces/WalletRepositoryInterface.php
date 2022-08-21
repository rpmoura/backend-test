<?php

namespace App\Repositories\Interfaces;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function createWallet(array $attributes);

    public function updateWallet(int $walletId, array $attributes);

    public function findWalletBy(string $key, int|string $value): ?Wallet;
}
