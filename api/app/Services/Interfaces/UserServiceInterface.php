<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function create(array $attributes): User;

    public function findUserByUuid(string $uuid);

    public function findUsers(): LengthAwarePaginator;
}
