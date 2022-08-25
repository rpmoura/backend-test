<?php

namespace Tests\Integrations\ExternalAuthorizer;

use App\Integrations\Client\Http\HttpClient;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7;
use Illuminate\Http\Client\HttpClientException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExternalAuthorizerTest extends TestCase
{
    use UsesGuzzler;

    private ExternalAuthorizer $integration;

    protected function setUp(): void
    {
        parent::setUp();

        $client            = $this->guzzler->getClient(config('services.external_authorizer'));
        $this->integration = new ExternalAuthorizer(new HttpClient($client));
    }

    /**
     * @test
     */
    public function shouldAuthorized()
    {
        $response = new Psr7\Response(Response::HTTP_OK, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = config('services.external_authorizer.base_uri') . '/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->assertIsArray($this->integration->requestAuthorizer());
    }

    /**
     * @test
     */
    public function shouldUnauthorized()
    {
        $response = new Psr7\Response(Response::HTTP_UNAUTHORIZED, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = config('services.external_authorizer.base_uri') . '/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->expectException(HttpClientException::class);

        $this->integration->requestAuthorizer();
    }
}
