<?php

namespace Tests\Listeners;

use App\Integrations\ExternalNotification\ExternalNotification;
use App\Integrations\ExternalNotification\ExternalNotificationInterface;
use App\Listeners\SendPayeeTransferNotification;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendPayeeTransferNotificationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldDispatched()
    {
        Queue::fake([SendPayeeTransferNotification::class]);

        $externalNotification = \Mockery::mock(ExternalNotification::class);
        $this->app->instance(ExternalNotificationInterface::class, $externalNotification);
        $externalNotification->shouldReceive('sendNotification')->once()->andReturns([]);

        $listener = new SendPayeeTransferNotification();
        $listener->handle();
    }

    /**
     * @test
     */
    public function shouldThrowException()
    {
        Queue::fake([SendPayeeTransferNotification::class]);

        $externalNotification = \Mockery::mock(ExternalNotification::class);
        $this->app->instance(ExternalNotificationInterface::class, $externalNotification);
        $externalNotification->shouldReceive('sendNotification')->once()->andThrowExceptions([new HttpClientException()]);

        Log::shouldReceive('error')->once()->withAnyArgs();

        $listener = new SendPayeeTransferNotification();
        $listener->handle();
    }
}
