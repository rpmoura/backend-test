<?php

namespace Tests\Http\Controllers\V1;

use App\Events\TransferPerformed;
use App\Exceptions\UnauthorizedTransferException;
use App\Http\Middleware\CanAbilities;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransferControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(CanAbilities::class);
    }

    /**
     * @test
     */
    public function shouldTransferSuccessfully()
    {
        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id, 'amount' => 50]);

        $this->actingAs($user);

        $otherUser = User::factory()->create();
        Wallet::factory()->create(['user_id' => $otherUser->id]);

        $transfer = [
            'payee'  => $otherUser->uuid,
            'amount' => fake()->numberBetween(1, 30)
        ];

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->andReturns([]);

        Event::fake([TransferPerformed::class]);

        $this->post('v1/transfers', ['transfer' => $transfer])->assertSuccessful();

        Event::assertDispatched(TransferPerformed::class);
    }

    /**
     * @test
     */
    public function shouldTransferUnauthorized()
    {
        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id, 'amount' => 50]);

        $this->actingAs($user);

        $otherUser = User::factory()->create();
        Wallet::factory()->create(['user_id' => $otherUser->id]);

        $transfer = [
            'payee'  => $otherUser->uuid,
            'amount' => fake()->numberBetween(1, 30)
        ];

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->andThrow(new UnauthorizedTransferException());

        Event::fake([TransferPerformed::class]);

        $this->post('v1/transfers', ['transfer' => $transfer])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        Event::assertNotDispatched(TransferPerformed::class);
    }

    /**
     * @test
     */
    public function shouldTransferInsufficientFunds()
    {
        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id, 'amount' => 50]);

        $this->actingAs($user);

        $otherUser = User::factory()->create();
        Wallet::factory()->create(['user_id' => $otherUser->id]);

        $transfer = [
            'payee'  => $otherUser->uuid,
            'amount' => 80
        ];

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->andReturn([]);

        Event::fake([TransferPerformed::class]);

        $this->post('v1/transfers', ['transfer' => $transfer])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        Event::assertNotDispatched(TransferPerformed::class);
    }

    /**
     * @test
     */
    public function shouldCantAbilitiesToTransfer()
    {
        $this->withMiddleware(CanAbilities::class);

        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id, 'amount' => 50]);

        Sanctum::actingAs($user);

        $otherUser = User::factory()->create();
        Wallet::factory()->create(['user_id' => $otherUser->id]);

        $transfer = [
            'payee'  => $otherUser->uuid,
            'amount' => fake()->numberBetween(1, 30)
        ];

        $this->post('v1/transfers', ['transfer' => $transfer])->assertUnauthorized();
    }

    /**
     * @test
     */
    public function shouldNotLoggedToTransfer()
    {
        $user = User::factory()->create();
        Wallet::factory()->create(['user_id' => $user->id, 'amount' => 50]);

        $otherUser = User::factory()->create();
        Wallet::factory()->create(['user_id' => $otherUser->id]);

        $transfer = [
            'payee'  => $otherUser->uuid,
            'amount' => fake()->numberBetween(1, 30)
        ];

        $this->post('v1/transfers', ['transfer' => $transfer])->assertUnauthorized();
    }
}
