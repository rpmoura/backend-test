<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function findUserByUuid(string $uuid);

    public function findUsers(): LengthAwarePaginator;
}
