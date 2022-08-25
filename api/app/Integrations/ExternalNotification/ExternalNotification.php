<?php

namespace App\Integrations\ExternalNotification;

use App\Integrations\Client\Http\HttpClientInterface;
use Illuminate\Http\Client\HttpClientException;

class ExternalNotification implements ExternalNotificationInterface
{
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    /**
     * @throws HttpClientException
     */
    public function sendNotification(): ?array
    {
        return $this->httpClient->post('/notify');
    }
}
