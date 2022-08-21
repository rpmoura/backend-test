<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function findUsers(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->userRepository->where()->paginate($perPage, ['*'], 'page', $page);
    }
}
