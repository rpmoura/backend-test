<?php

namespace App\Integrations\ExternalNotification;

use App\Integrations\Client\Http\HttpClientInterface;

class ExternalNotification implements ExternalNotificationInterface
{
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    public function sendNotification(): ?array
    {
        return $this->httpClient->post('/notify');
    }
}
