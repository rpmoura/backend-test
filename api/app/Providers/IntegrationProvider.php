<?php

namespace App\Providers;

use App\Integrations\Client\Http\HttpClient;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use App\Integrations\ExternalNotification\ExternalNotification;
use App\Integrations\ExternalNotification\ExternalNotificationInterface;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\ServiceProvider;

class IntegrationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ExternalAuthorizerInterface::class,
            function () {
                return new ExternalAuthorizer(
                    new HttpClient(new GuzzleHttpClient(config('services.external_authorizer')))
                );
            }
        );

        $this->app->singleton(
            ExternalNotificationInterface::class,
            function () {
                return new ExternalNotification(
                    new HttpClient(new GuzzleHttpClient(config('services.external_notification')))
                );
            }
        );
    }
}
