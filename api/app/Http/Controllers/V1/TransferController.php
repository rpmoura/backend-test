<?php

namespace App\Http\Controllers\V1;

use App\Events\TransferPerformed;
use App\Exceptions\InsufficientFundsException;
use App\Exceptions\UnauthorizedTransferException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\WalletResource;
use App\Services\Interfaces\{UserServiceInterface, WalletServiceInterface};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class TransferController extends Controller
{
    public function __construct(
        protected WalletServiceInterface $walletService,
        protected UserServiceInterface $userService
    ) {}

    public function transfer(TransferRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated('transfer');

            /** @var \App\Models\User $payer */
            $payer = auth()->user();

            DB::beginTransaction();

            $payee = $this->userService->findUserByUuid($validated['payee']);

            $payerWallet = $this->walletService->findByOwner($payer);

            $payeeWallet = $this->walletService->findByOwner($payee);

            $transferData = [
                'payer_wallet' => $payerWallet,
                'payee_wallet' => $payeeWallet,
                'amount'       => $validated['amount']
            ];

            $payerWallet = $this->walletService->completeTransfer($transferData);

            DB::commit();

            event(new TransferPerformed($transferData));

            return $this->buildResponse(
                __('message.transfer.successfully'),
                ['wallet' => new WalletResource($payerWallet)],
                Response::HTTP_CREATED
            );
        } catch (UnauthorizedTransferException | InsufficientFundsException $exception) {
            DB::rollBack();
            return $this->buildResponseError($exception, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
