<?php

namespace App\Services\Interfaces;

interface TransferServiceInterface
{
    public function validateTransfer(array $attributes);
}
