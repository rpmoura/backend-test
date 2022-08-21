<?php

namespace App\Http\Controllers\V1\Auth;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function signIn(SignInRequest $request): JsonResponse
    {
        try {
            if (auth()->attempt(['email' => $request->credential, 'password' => $request->password])) {
                /** @var User $user */
                $user = auth()->user();
                // TODO mover para camada de serviço
                $permission = $user->type == UserTypeEnum::COMMON ? 'can-transfer' : '';
                $data       = (object)[
                    'token' => $user->createToken('auth_token', [$permission])->plainTextToken,
                    'user'  => $user,
                ];

                return $this->buildResponse(__('auth.successfully'), new AuthResource($data), Response::HTTP_OK);
            }
            throw new UnauthorizedHttpException('', __('exception.auth.unauthorized'));
        } catch (UnauthorizedHttpException $exception) {
            return $this->buildResponseError($exception, Response::HTTP_UNAUTHORIZED);
        }
    }
}
