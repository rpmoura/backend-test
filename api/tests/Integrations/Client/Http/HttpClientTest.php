<?php

namespace Tests\Integrations\Client\Http;

use App\Integrations\Client\Http\HttpClient;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7;
use Illuminate\Http\Client\HttpClientException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HttpClientTest extends TestCase
{
    use UsesGuzzler;

    private HttpClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        $client = $this->guzzler->getClient(['base_uri' => 'https://any.test']);
        $this->client = new HttpClient($client);
    }

    /**
     * @test
     */
    public function shouldRequest()
    {
        $response = new Psr7\Response(Response::HTTP_OK, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = 'https://any.test';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->client->post('https://any.test');
    }

    /**
     * @test
     */
    public function shouldThrowException()
    {
        $response = new Psr7\Response(Response::HTTP_NOT_FOUND, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = 'https://any.test';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->expectException(HttpClientException::class);

        $this->client->post('https://any.test');
    }
}
