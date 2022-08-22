<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class UserRepository implements UserRepositoryInterface
{
    public function findUserBy(string $key, int|string $value): ?User
    {
        return User::query()->where($key, $value)->get()->first();
    }

    public function createUser(array $attributes): User
    {
        return User::create($attributes);
    }

    public function findUsers(?array $conditions = null): Builder
    {
        return User::query()->where($conditions);
    }
}
