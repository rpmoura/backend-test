<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function buildResponse(string $message, $data, int $codeStatus = 200): JsonResponse
    {
        $response = [
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $codeStatus);
    }

    protected function buildResponseError($exception, int $codeStatus): JsonResponse
    {
        $field   = null;
        $message = $exception->getMessage();
        if (method_exists($exception, 'getMessageBag')) {
            $message = $exception->getMessageBag()->first();
            $field   = $exception->getMessageBag()->keys()[0];
        }

        $data = method_exists($exception, 'getParams') ? $exception->getParams() : null;

        $this->response = [
            'type'    => 'error',
            'message' => $message,
            'data'    => $data,
            'field'   => $field,
        ];

        return response()->json($this->response, $codeStatus);
    }
}
