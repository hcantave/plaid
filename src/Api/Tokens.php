<?php

namespace Abivia\Plaid\Api;

use Abivia\Plaid\Entities\AccountFilters;
use Abivia\Plaid\Entities\User;
use Abivia\Plaid\PlaidRequestException;

class Tokens extends AbstractResource
{
    /**
     * Create a Link Token.
     *
     * @param  string  $language  Possible values are: en, fr, es, nl
     * @param  array<string>  $countryCodes  Possible values are: CA, FR, IE, NL, ES, GB, US
     * @param  array<string>  $products  Possible values are: transactions, auth, identity, income, assets, investments, liabilities, payment_initiation
     *
     * @throws PlaidRequestException
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function create(
        string $clientName,
        string $language,
        array $countryCodes,
        User $user,
        array $products = [],
        ?string $webhook = null,
        ?string $linkCustomizationName = null,
        ?AccountFilters $accountFilters = null,
        ?string $accessToken = null,
        ?string $redirectUri = null,
        ?string $androidPackageName = null,
        ?string $paymentId = null,
        ?string $institutionId = null): self
    {
        static $argMap = [
            'accessToken' => 'access_token',
            'androidPackageName' => 'android_package_name',
            'institutionId' => 'institution_id',
            'linkCustomizationName' => 'link_customization_name',
            'redirectUri' => 'redirect_uri',
            'webhook' => 'webhook',
        ];

        $params = [
            'client_name' => $clientName,
            'language' => $language,
            'country_codes' => $countryCodes,
            'user' => $user->toArray(),
            'products' => $products,
        ];
        foreach ($argMap as $argument => $param) {
            if ($$argument !== null) {
                $params[$param] = $$argument;
            }
        }
        if ($accountFilters) {
            $params['account_filters'] = $accountFilters->toArray();
        }
        if ($paymentId) {
            $params['payment_initiation'] = [
                'payment_id' => $paymentId,
            ];
        }

        $this->sendRequest('link/token/create', $params);

        return $this;
    }

    /**
     * Get information about a previously created Link token.
     *
     * @throws PlaidRequestException
     */
    public function get(string $linkToken): self
    {
        $this->sendRequest('link/token/get', ['link_token' => $linkToken]);

        return $this;
    }
}
