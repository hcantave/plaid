<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\PlaidRequestException;

class Processors extends AbstractResource
{
    /**
     * Create a processor token.
     *
     * @throws PlaidRequestException
     */
    public function createToken(string $accessToken, string $accountId, string $processor): self
    {
        $this->sendRequest(
            'processor/token/create',
            [
                'access_token' => $accessToken,
                'account_id' => $accountId,
                'processor' => $processor,
            ]
        );

        return $this;
    }

    /**
     * Get processor auth data.
     *
     * @throws PlaidRequestException
     */
    public function getAuth(string $processorToken): self
    {
        $this->sendRequest(
            'processor/auth/get',
            ['processor_token' => $processorToken]
        );

        return $this;
    }

    /**
     * Get the balance of accounts from processor.
     *
     * @throws PlaidRequestException
     */
    public function getBalance(string $processorToken): self
    {
        $this->sendRequest(
            'processor/balance/get',
            ['processor_token' => $processorToken]
        );

        return $this;
    }

    /**
     * Get account holder information from the processor.
     *
     * @throws PlaidRequestException
     */
    public function getIdentity(string $processorToken): self
    {
        $this->sendRequest(
            'processor/identity/get',
            ['processor_token' => $processorToken]
        );

        return $this;
    }

    /**
     * Create Stripe token.
     *
     * @throws PlaidRequestException
     */
    public function createStripeToken(string $accessToken, string $accountId): self
    {
        $this->sendRequest(
            'processor/stripe/bank_account_token/create',
            [
                'access_token' => $accessToken,
                'account_id' => $accountId,
            ]
        );

        return $this;
    }

    /**
     * Create Dwolla token.
     *
     * @throws PlaidRequestException
     */
    public function createDwollaToken(string $accessToken, string $accountId): self
    {
        $this->sendRequest(
            'processor/dwolla/processor_token/create',
            [
                'access_token' => $accessToken,
                'account_id' => $accountId,
            ]
        );

        return $this;
    }
}
