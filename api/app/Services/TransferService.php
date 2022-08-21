<?php

namespace App\Services;

use App\Rules\Transfer\AuthorizeTransfer;
use App\Rules\Transfer\ValidateFunds;
use App\Exceptions\InsufficientFundsException;
use App\Exceptions\UnauthorizedTransferException;
use App\Services\Interfaces\TransferServiceInterface;

class TransferService implements TransferServiceInterface
{
    /**
     * @throws InsufficientFundsException
     * @throws UnauthorizedTransferException
     */
    public function validateTransfer(array $attributes): void
    {
        $validator = new AuthorizeTransfer(new ValidateFunds());
        $validator->handle($attributes);
    }
}
