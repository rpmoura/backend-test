<?php

namespace App\Integrations\Client\Http;

use Illuminate\Http\Client\HttpClientException;

interface HttpClientInterface
{
    /**
     * @throws HttpClientException
     */
    public function post(string $uri, array $body = null, array $headers = []): ?array;
}
