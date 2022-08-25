<?php

namespace Tests\Integrations\ExternalNotification;

use App\Integrations\Client\Http\HttpClient;
use App\Integrations\ExternalNotification\ExternalNotification;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7;
use Illuminate\Http\Client\HttpClientException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExternalNotificationTest extends TestCase
{
    use UsesGuzzler;

    private ExternalNotification $integration;

    protected function setUp(): void
    {
        parent::setUp();

        $client            = $this->guzzler->getClient(config('services.external_notification'));
        $this->integration = new ExternalNotification(new HttpClient($client));
    }

    /**
     * @test
     */
    public function shouldSendNotification()
    {
        $response = new Psr7\Response(Response::HTTP_OK, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = config('services.external_notification.base_uri') . '/notify';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->assertIsArray($this->integration->sendNotification());
    }

    /**
     * @test
     */
    public function shouldNotSendNotification()
    {
        $response = new Psr7\Response(Response::HTTP_UNAUTHORIZED, [], Psr7\Utils::streamFor(json_encode([])));

        $endpoint = config('services.external_notification.base_uri') . '/notify';

        $this->guzzler->expects($this->once())
            ->post($endpoint)
            ->willRespond($response);

        $this->expectException(HttpClientException::class);

        $this->integration->sendNotification();
    }
}
