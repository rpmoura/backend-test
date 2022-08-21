<?php

namespace App\Integrations\Client\Http;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Client\HttpClientException;

class HttpClient implements HttpClientInterface
{
    public function __construct(protected GuzzleHttpClient $client)
    {
    }

    /**
     * @throws HttpClientException
     */
    public function post(string $uri, ?array $body = null, array $headers = []): ?array
    {
        try {
            $response = $this->client->request('POST', $uri, ['body' => $body, 'headers' => $headers]);
            return json_decode($response->getBody()->__toString(), true);
        } catch (ClientException | ServerException | ConnectException | BadResponseException | RequestException | GuzzleException $e) {
            throw new HttpClientException(__('exception.http.request_error'));
        }
    }
}
