<?php

namespace App\Integrations\ExternalNotification;

use Illuminate\Http\Client\HttpClientException;

interface ExternalNotificationInterface
{
    /**
     * @throws HttpClientException
     */
    public function sendNotification();
}
