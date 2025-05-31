<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\PlaidRequestException;
use Illuminate\Support\Carbon;

class Transactions extends AbstractResource
{
    /**
     * Get all transactions for a particular Account.
     *
     * @param  array<string,mixed>  $options
     *
     * @throws PlaidRequestException
     */
    public function list(
        string $accessToken,
        Carbon $startDate,
        Carbon $endDate,
        array $options = []
    ): self {
        $this->sendRequest(
            'transactions/get',
            [
                'access_token' => $accessToken,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'options' => (object) $options,
            ]
        );

        return $this;
    }

    /**
     * Refresh transactions for a particular Account.
     *
     * @throws PlaidRequestException
     */
    public function refresh(string $accessToken): self
    {
        $this->sendRequest('transactions/refresh', ['access_token' => $accessToken]);

        return $this;
    }
}
