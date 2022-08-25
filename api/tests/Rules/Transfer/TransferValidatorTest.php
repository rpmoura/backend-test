<?php

namespace Tests\Rules\Transfer;

use App\Exceptions\InsufficientFundsException;
use App\Exceptions\UnauthorizedTransferException;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizer;
use App\Integrations\ExternalAuthorizer\ExternalAuthorizerInterface;
use App\Models\Wallet;
use App\Rules\Transfer\AuthorizeTransfer;
use App\Rules\Transfer\Handler;
use App\Rules\Transfer\ValidateFunds;
use Illuminate\Http\Client\HttpClientException;
use Tests\TestCase;

class TransferValidatorTest extends TestCase
{
    private Handler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new ValidateFunds(new AuthorizeTransfer());
    }

    /**
     * @test
     */
    public function shouldValidateFunds()
    {
        $wallet = Wallet::factory()->create(['amount' => 20]);

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->once()->andReturn([]);

        $this->assertNull($this->handler->handle(['payer_wallet' => $wallet, 'amount' => 10]));
    }

    /**
     * @test
     */
    public function shouldAuthorizeTransfer()
    {
        $wallet = Wallet::factory()->create(['amount' => 20]);

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->once()->andReturn([]);

        $this->assertNull($this->handler->handle(['payer_wallet' => $wallet, 'amount' => 10]));
    }

    /**
     * @test
     */
    public function shouldUnauthorizedTransfer()
    {
        $wallet = Wallet::factory()->create(['amount' => 20]);

        $externalAuthorizer = \Mockery::mock(ExternalAuthorizer::class);
        $this->app->instance(ExternalAuthorizerInterface::class, $externalAuthorizer);
        $externalAuthorizer->shouldReceive('requestAuthorizer')->once()->andThrow(HttpClientException::class);

        $this->expectException(UnauthorizedTransferException::class);

        $this->handler->handle(['payer_wallet' => $wallet, 'amount' => 10]);
    }

    /**
     * @test
     */
    public function shouldInvalidFunds()
    {
        $wallet = Wallet::factory()->create(['amount' => 5]);

        $this->expectException(InsufficientFundsException::class);

        $this->handler->handle(['payer_wallet' => $wallet, 'amount' => 10]);
    }
}
