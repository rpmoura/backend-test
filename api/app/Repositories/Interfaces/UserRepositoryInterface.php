<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function findUserBy(string $key, int|string $value): ?User;

    public function createUser(array $attributes): User;

    public function findUsers(array $conditions): Builder;
}
