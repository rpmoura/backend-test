<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\{UserServiceInterface, WalletServiceInterface};
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected WalletServiceInterface $walletService
    ) {
    }

    public function create(UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated('user');

            $user = $this->userService->create($validated);

            $wallet = $this->walletService->create($user);

            DB::commit();

            return $this->buildResponse(
                __('message.user.created_successfully'),
                [
                    'user'   => new UserResource($user),
                    'wallet' => new WalletResource($wallet),
                ],
                Response::HTTP_CREATED
            );
        } catch (QueryException $exception) {
            DB::rollBack();
            return $this->buildResponseError($exception, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function get(Request $request): JsonResponse
    {
        $result = $this->userService->findUsers($request->get('per_page'), $request->get('page'));

        return $this->buildResponse(
            __('message.user.created_successfully'),
            [
               'users' => $result->toArray()
            ],
            Response::HTTP_CREATED
        );
    }
}
