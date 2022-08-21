<?php

namespace App\Listeners;

use App\Integrations\ExternalNotification\ExternalNotificationInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class SendPayeeTransferNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     * @throws \Illuminate\Http\Client\HttpClientException
     */
    public function handle()
    {
        try {
            /** @var ExternalNotificationInterface $notificationService */
            $notificationService = app(ExternalNotificationInterface::class);
            $notificationService->sendNotification();
        } catch (HttpClientException $exception) {
            Log::error('external-notification', ['exception' => $exception->getMessage()]);
        }
    }
}
