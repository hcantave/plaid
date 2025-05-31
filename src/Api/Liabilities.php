<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\PlaidRequestException;

class Liabilities extends AbstractResource
{
    /**
     * Get Liabilities request.
     *
     * @param  array<string,mixed>  $options
     *
     * @throws PlaidRequestException
     */
    public function list(string $accessToken, array $options = []): self
    {
        $this->sendRequest(
            'liabilities/get',
            [
                'access_token' => $accessToken,
                'options' => (object) $options,
            ]
        );

        return $this;
    }
}
