<?php

namespace App\Rules\Transfer;

use App\Exceptions\InsufficientFundsException;

class ValidateFunds extends Handler
{
    /**
     * @throws InsufficientFundsException
     */
    public function validate(array $attributes)
    {
        $payerWallet = $attributes['payer_wallet'];
        $amount      = $attributes['amount'];

        if ($payerWallet->amount < $amount) {
            throw new InsufficientFundsException(__('exception.transfer.insufficient_funds'));
        }

        return null;
    }
}
