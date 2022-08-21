<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function findUserByUuid(string $uuid);

    public function findUsers();
}
