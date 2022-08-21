<?php

namespace App\Integrations\ExternalAuthorizer;

use Illuminate\Http\Client\HttpClientException;

interface ExternalAuthorizerInterface
{
    /**
     * @throws HttpClientException
     */
    public function requestAuthorizer();
}
