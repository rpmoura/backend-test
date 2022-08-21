<?php

namespace App\Exceptions;

use HttpResponseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        return match (true) {
            $exception instanceof AccessDeniedHttpException,
            $exception instanceof HttpResponseException,
            $exception instanceof BadRequestHttpException,
            $exception instanceof NotFoundHttpException,
            $exception instanceof UnauthorizedHttpException,
            $exception instanceof InvalidArgumentException,
            $exception instanceof MethodNotAllowedHttpException => response()->json(
                [
                    'type'    => 'error',
                    'message' => $exception->getMessage() ?: trans('exception.method_not_allowed'),
                ],
                $exception->getStatusCode()
            ),
            default => parent::render($request, $exception),
        };
    }
}
