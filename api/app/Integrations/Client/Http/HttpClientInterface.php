<?php

namespace App\Integrations\Client\Http;

interface HttpClientInterface
{
    public function post(string $uri, array $body = null, array $headers = []): ?array;
}
