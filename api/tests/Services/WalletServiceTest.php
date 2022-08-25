<?php

namespace Tests\Services;

use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\WalletService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{
    private WalletService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $repository    = new WalletRepository();
        $this->service = new WalletService($repository);
    }

    /**
     * @test
     */
    public function shouldCreateWallet()
    {
        $user   = User::factory()->create();
        $amount = 40;

        $result = $this->service->create($user, $amount);

        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals($amount, $result->amount);
        $this->assertDatabaseCount('wallets', 1);
    }

    /**
     * @test
     */
    public function shouldFindByOwner()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create();

        $result = $this->service->findByOwner($user);

        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals($wallet->id, $result->id);
    }

    /**
     * @test
     */
    public function shouldCompleteTransfer()
    {
        $payer       = User::factory()->create();
        $payerWallet = Wallet::factory()->create(['user_id' => $payer->id, 'amount' => 100]);

        $payee       = User::factory()->shopkeeper()->create();
        $payeeWallet = Wallet::factory()->create(['user_id' => $payee->id, 'amount' => 50]);

        $attributes = [
            'payer_wallet' => $payerWallet,
            'payee_wallet' => $payeeWallet,
            'amount'       => 10
        ];

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->once()->andReturn([]);

        $result = $this->service->completeTransfer($attributes);

        $this->assertEquals(90, $result->amount);
        $this->assertDatabaseHas('wallets', ['id' => $payee->id, 'amount' => 60]);
    }

    /**
     * @test
     */
    public function shouldNotFoundOwner()
    {
        $this->withoutEvents();

        $user = User::factory()->create();

        $this->expectException(NotFoundHttpException::class);

        $this->service->findByOwner($user);
    }

}
