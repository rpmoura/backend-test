<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService implements UserServiceInterface
{

    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function create(array $attributes): User
    {
        return $this->userRepository->create($attributes);
    }

    public function findUserByUuid(string $uuid): User
    {
        $user = $this->userRepository->findUserBy('uuid', $uuid);

        if ($user instanceof User) {
            return $user;
        }

        throw new NotFoundHttpException(__('exception.user.not_found'));
    }

    public function findUsers(): Builder
    {
        return $this->userRepository->where();
    }
}
