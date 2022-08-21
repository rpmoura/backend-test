<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Interfaces\WalletRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class WalletRepository implements WalletRepositoryInterface
{
    public function createWallet(array $attributes): Wallet
    {
        return Wallet::create($attributes);
    }

    public function updateWallet(int $walletId, array $attributes): Wallet
    {
        $wallet = Wallet::find($walletId);
        $wallet->update($attributes);
        $wallet->save();

        return $wallet->refresh();
    }

    public function findWalletBy(string $key, int|string $value): ?Wallet
    {
        return Wallet::query()->where($key, $value)->get()->first();
    }
}
