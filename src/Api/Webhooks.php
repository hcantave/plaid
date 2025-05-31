<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\PlaidRequestException;

class Webhooks extends AbstractResource
{
    /**
     * Get public key corresponding to key id inside webhook request.
     *
     * @throws PlaidRequestException
     */
    public function getVerificationKey(string $keyId): self
    {
        $this->sendRequest('webhook_verification_key/get', ['key_id' => $keyId]);

        return $this;
    }

    /**
     * Update an Item webhook.
     *
     * @throws PlaidRequestException
     */
    public function update(string $accessToken, string $webhook): self
    {
        $this->sendRequest(
            'item/webhook/update',
            [
                'access_token' => $accessToken,
                'webhook' => $webhook,
            ]
        );

        return $this;
    }
}
