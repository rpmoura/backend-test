<?php

namespace Tests\Events;

use App\Events\TransferPerformed;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CanAbilities;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use App\Integrations\ExternalNotification\ExternalNotification;
use App\Integrations\ExternalNotification\ExternalNotificationInterface;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TransferPerformedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
        $this->withoutMiddleware(CanAbilities::class);
    }

    /**
     * @test
     */
    public function shouldDispatchEvent()
    {
        Event::fake([TransferPerformed::class]);

        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $shopkeeper = User::factory()->shopkeeper()->create();
        Wallet::factory()->create(['user_id' => $shopkeeper->id]);

        $data = [
            'payee'  => $shopkeeper->uuid,
            'amount' => 1
        ];

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->andReturns([]);

        $externalNotification = \Mockery::mock(ExternalNotification::class);
        $this->app->instance(ExternalNotificationInterface::class, $externalNotification);
        $externalNotification->shouldReceive('sendNotification')->andReturns([]);

        $this->post('/v1/transfers', ['transfer' => $data])->assertSuccessful();

        Event::assertDispatched(TransferPerformed::class);
    }
}
