<?php

namespace App\Integrations\ExternalAuthorizer;

use App\Integrations\Client\Http\HttpClientInterface;

class ExternalAuthorizer implements ExternalAuthorizerInterface
{
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    public function requestAuthorizer(): ?array
    {
        return $this->httpClient->post('/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    }
}
