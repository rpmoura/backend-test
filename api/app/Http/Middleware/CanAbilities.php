<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CanAbilities
{
    public function handle(Request $request, Closure $next, string $ability)
    {
        if (!$request->user()->tokenCan($ability)) {
            throw new UnauthorizedHttpException(
                '',
                __('exception.auth.unauthorized'),
                null,
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
