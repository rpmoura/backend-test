<?php

namespace App\Rules\Transfer;

use App\Exceptions\UnauthorizedTransferException;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use Illuminate\Http\Client\HttpClientException;

class AuthorizeTransfer extends Handler
{
    /**
     * @throws UnauthorizedTransferException
     */
    public function validate(array $attributes)
    {
        try {
            /** @var ExternalAuthorizerInterface $externalAuthorizer */
            $externalAuthorizer = app(ExternalAuthorizerInterface::class);
            $externalAuthorizer->requestAuthorizer();
        } catch (HttpClientException) {
            throw new UnauthorizedTransferException(__('exception.transfer.unauthorized'));
        }

        return null;
    }
}
