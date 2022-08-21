<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    public function findUserBy(string $key, int|string $value): ?User;

    public function create(array $attributes): User;

    public function where(array $conditions): Builder;
}
