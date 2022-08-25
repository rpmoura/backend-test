<?php

namespace App\Repositories;

use App\Models\Wallet;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    private WalletRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new WalletRepository();
    }

    /**
     * @test
     */
    public function shouldCreateWallet()
    {
        $attributes = Wallet::factory()->make()->toArray();

        $result = $this->repository->createWallet($attributes);

        $this->assertInstanceOf(Wallet::class, $result);
    }

    /**
     * @test
     */
    public function shouldFindWallet()
    {
        $wallet = Wallet::factory()->create();

        $result = $this->repository->findWalletBy('uuid', $wallet->uuid);

        $this->assertEquals($wallet->id, $result->id);
    }

    /**
     * @test
     */
    public function shouldNotFoundWallet()
    {
        $result = $this->repository->findWalletBy('uuid', fake()->uuid());

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldUpdateWallet()
    {
        $oldAmount = 30;
        $newAmount = 50;

        $wallet = Wallet::factory()->create(['amount' => $oldAmount]);

        $result = $this->repository->updateWallet($wallet->id, ['amount' => $newAmount]);

        $this->assertEquals($newAmount, $result->amount);
        $this->assertEquals($wallet->uuid, $result->uuid);
    }
}
