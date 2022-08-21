<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Services\Interfaces\WalletServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WalletService implements WalletServiceInterface
{
    public function __construct(protected WalletRepositoryInterface $walletRepository) {}

    public function create(User $user, float $amount = 0): Wallet
    {
        $attributes = [
            'user_id' => $user->id,
            'amount'  => $amount
        ];

        return $this->walletRepository->createWallet($attributes);
    }

    public function findByOwner(User $owner): Wallet
    {
        $wallet = $this->walletRepository->findWalletBy('user_id', $owner->id);

        if ($wallet instanceof Wallet) {
            return $wallet;
        }

        throw new NotFoundHttpException(__('exception.wallet.not_found'));
    }

    public function completeTransfer(array $attributes): Wallet
    {
        $payerWallet = $attributes['payer_wallet'];
        $payeeWallet = $attributes['payee_wallet'];
        $amount      = $attributes['amount'];

        $this->walletRepository->updateWallet($payeeWallet->id, ['amount' => $payeeWallet->amount + $amount]);
        $this->walletRepository->updateWallet($payerWallet->id, ['amount' => $payerWallet->amount - $amount]);

        return $payerWallet->refresh();
    }
}
