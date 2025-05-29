<?php

namespace Hcantave\Plaid\Client;

use Hcantave\Plaid\Resources\AccessTokenResource;
use Hcantave\Plaid\Resources\AccountsResource;
use Hcantave\Plaid\Resources\InstitutionCollectionResource;
use Hcantave\Plaid\Resources\InstitutionResource;
use Hcantave\Plaid\Resources\ItemRemoveResource;
use Hcantave\Plaid\Resources\ItemResource;
use Hcantave\Plaid\Resources\LinkTokenResource;
use Hcantave\Plaid\Resources\NewAccessTokenResource;
use Hcantave\Plaid\Resources\PublicTokenResource;
use Hcantave\Plaid\Resources\ResetItemResource;
use Hcantave\Plaid\Resources\TransactionsResource;
use Hcantave\Plaid\Resources\WebhookFiredResource;
use DateTime;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Spatie\LaravelData\Exceptions\InvalidDataClass;
use function config;

class Factory
{
    public const API_VERSION = '2020-09-14';

    protected array $plaidEnvironments = [
        'sandbox'    => 'https://sandbox.plaid.com',
        'development'=> 'https://development.plaid.com',
        'production' => 'https://production.plaid.com',
    ];

    protected readonly string $hostname;
    protected readonly array $headers;

    protected array $products;

    protected string $language;

    protected string $webhook;

    protected array $countryCodes;

    public function __construct(
        protected readonly string $clientId,
        protected readonly string $secret,
        protected readonly string $environment,
        protected readonly string $clientName
    ) {
        $this->hostname = $this->plaidEnvironments[$this->environment];
        $this->products = config('plaid.products');
        $this->countryCodes = config('plaid.country_codes');
        $this->language = config('plaid.language');
        $this->webhook = url(config('plaid.webhook'));

        $this->headers = [
            'Plaid-Version' => self::API_VERSION,
            'PLAID-CLIENT-ID' => $this->clientId,
            'PLAID-SECRET' => $this->secret,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Send a request and return the response.
     *
     * @param string $endpoint
     * @param array $body
     * @return Response
     * @throws RequestException
     */
    private function sendRequest(string $endpoint, array $body): Response
    {
        return Http::withHeaders($this->headers)
            ->baseUrl($this->hostname)
            ->post($endpoint, $body)
            ->throw();
    }

    /**
     * Returns information about the status of an Item.
     *
     * @link https://plaid.com/docs/api/items/#itemget
     *
     * @param string $accessToken
     * @return ItemResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function getItem(string $accessToken): ItemResource
    {
        return ItemResource::from($this->sendRequest('item/get', [
            'access_token' => $accessToken,
        ])->json());
    }

    /**
     * Remove an Item.
     *
     * Once removed, the access_token associated with the Item is
     * no longer valid and cannot be used to access any data that
     * was associated with the Item.
     *
     * @link https://plaid.com/docs/api/items/#itemremove
     *
     * @param string $accessToken
     * @return ItemRemoveResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function removeItem(string $accessToken): ItemRemoveResource
    {
        return ItemRemoveResource::from($this->sendRequest('item/remove', [
            'access_token' => $accessToken,
        ])->json());
    }

    /**
     * Update the webhook URL associated with an Item.
     *
     * @link https://plaid.com/docs/api/items/#itemwebhookupdate
     *
     * @param string $accessToken
     * @param string $webhook
     * @return ItemResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function updateWebhook(string $accessToken, string $webhook): ItemResource
    {
        return ItemResource::from($this->sendRequest('item/webhook/update', [
            'access_token' => $accessToken,
            'webhook' => $webhook,
        ])->json());
    }

    /**
     * Returns details on all financial institutions currently supported by Plaid.
     *
     * Because Plaid supports thousands of institutions, results are paginated.
     *
     * @link https://plaid.com/docs/api/institutions/#institutionsget
     *
     * @param int $count
     * @param int $offset
     * @param array $options
     * @return InstitutionCollectionResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function listInstitutions(int $count, int $offset, array $options = []): InstitutionCollectionResource
    {
        $options = array_merge([
            'include_optional_metadata' => true,
            'products' => $this->products,
        ], $options);

        if ($count < 1 || $count > 500) {
            throw new InvalidArgumentException('count must be between 0 and 500');
        }

        if ($offset < 0) {
            throw new InvalidArgumentException('offset must be greater than zero');
        }

        return InstitutionCollectionResource::from($this->sendRequest('institutions/get', [
            'count' => $count,
            'offset' => $offset,
            'country_codes' => $this->countryCodes,
            'options' => $options,
        ])->json());
    }

    /**
     * Returns a specified financial institution currently supported by Plaid.
     *
     * @link https://plaid.com/docs/api/institutions/#institutionsget_by_id
     *
     * @param string $institutionId
     * @param array $options
     * @return InstitutionResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function getInstitution(string $institutionId, array $options = []): InstitutionResource
    {
        $options = array_merge([
            'include_optional_metadata' => true,
        ], $options);

        return InstitutionResource::from($this->sendRequest('institutions/get_by_id', [
            'institution_id' => $institutionId,
            'country_codes' => $this->countryCodes,
            'options' => $options,
        ])->json());
    }

    /**
     * Returns institutions that match the query parameters.
     *
     * Up to a maximum of ten institutions per query
     *
     * @link https://plaid.com/docs/api/institutions/#institutionssearch
     *
     * @param string $query
     * @param array $options
     * @return InstitutionCollectionResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function searchInstitutions(string $query, array $options = []): InstitutionCollectionResource
    {
        $options = array_merge([
            'include_optional_metadata' => true,
        ], $options);

        return InstitutionCollectionResource::from($this->sendRequest('institutions/search', [
            'query' => $query,
            'country_codes' => $this->countryCodes,
            'products' => $this->products,
            'options' => $options,
        ])->json());
    }

    /**
     * Retrieve a list of accounts associated with any linked Item.
     *
     * @link https://plaid.com/docs/api/accounts/#accountsget
     *
     * @param string $accessToken
     * @return AccountsResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function getAccounts(string $accessToken): AccountsResource
    {
        $responseData = $this->sendRequest('accounts/get', [
            'access_token' => $accessToken,
        ])->json();

        // Use from() method instead of constructor
        return AccountsResource::from($responseData);
    }

    /**
     * Creates a link_token, which is required as a parameter when initializing Link.
     *
     * @link https://plaid.com/docs/api/tokens/#linktokencreate
     *
     * @param string $userId
     * @param array $options
     * @return LinkTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function createLinkToken(string $userId, array $options = []): LinkTokenResource
    {
        return LinkTokenResource::from($this->sendRequest('link/token/create', array_merge([
            'client_name' => $this->clientName,
            'language' => $this->language,
            'country_codes' => $this->countryCodes,
            'user' => ['client_user_id' => $userId],
            'products' => $this->products,
            'webhook' => $this->webhook,
        ], $options))->json());
    }

    /**
     * Creates a link_token in update/modify mode.
     *
     * @link https://plaid.com/docs/api/tokens/#linktokencreate
     *
     * @param string $userId
     * @param string $accessToken
     * @param array $options
     * @return LinkTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function updateLinkToken(string $userId, string $accessToken, array $options = []): LinkTokenResource
    {
        return LinkTokenResource::from($this->sendRequest('link/token/create', array_merge([
            'client_name' => $this->clientName,
            'language' => $this->language,
            'country_codes' => $this->countryCodes,
            'user' => ['client_user_id' => $userId],
            'access_token' => $accessToken,
            'update' => [
                'account_selection_enabled' => true,
            ],
        ], $options))->json());
    }

    /**
     * Exchange a Link public_token for an API access_token.
     *
     * @link https://plaid.com/docs/api/tokens/#itempublic_tokenexchange
     *
     * @param string $publicToken
     * @return AccessTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function exchangePublicToken(string $publicToken): AccessTokenResource
    {
        return AccessTokenResource::from($this->sendRequest('item/public_token/exchange', [
            'public_token' => $publicToken,
        ])->json());
    }

    /**
     * Rotate the access_token associated with an Item.
     *
     * The method returns a new access_token and immediately invalidates
     * the previous access_token.
     *
     * @link https://plaid.com/docs/api/tokens/#itemaccess_tokeninvalidate
     *
     * @param string $accessToken
     * @return NewAccessTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function rotateAccessToken(string $accessToken): NewAccessTokenResource
    {
        return NewAccessTokenResource::from($this->sendRequest('item/access_token/invalidate', [
            'access_token' => $accessToken,
        ])->json());
    }

    /**
     * Fetch transactions between two dates.
     *
     * @param string $accessToken
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return TransactionsResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function fetchTransactions(string $accessToken, DateTime $startDate, DateTime $endDate): TransactionsResource
    {
        $offset = 0;
        $count = 100;
        $transactionsToFetch = true;

        $item = [];
        $accounts = [];
        $transactions = [];

        while ($transactionsToFetch) {
            $body = [
                'access_token' => $accessToken,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'options' => [
                    'count' => $count,
                    'offset' => $offset,
                ],
            ];

            $response = $this->sendRequest('transactions/get', $body)->json();

            $item = $response['item'];
            $accounts = $response['accounts'];
            $transactions = array_merge($transactions, $response['transactions']);

            if (count($response['transactions']) !== $count) {
                $transactionsToFetch = false;
            }

            $offset += $count;
        }

        return TransactionsResource::from([
            'item' => $item,
            'accounts' => $accounts,
            'transactions' => $transactions,
            'total_transactions' => count($transactions),
        ]);
    }

    /**
     * Create a valid public_token for an arbitrary institution ID.
     *
     * @link https://plaid.com/docs/api/sandbox/#sandboxpublic_tokencreate
     *
     * @param string $institutionId
     * @param array|null $options
     * @return PublicTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function createPublicToken(string $institutionId, array $options = null): PublicTokenResource
    {
        if ($this->environment !== 'sandbox') {
            throw new RuntimeException('method createPublicToken() only available in sandbox mode.');
        }

        return PublicTokenResource::from($this->sendRequest('sandbox/public_token/create', [
            'institution_id' => $institutionId,
            'initial_products' => $this->products,
            'options' => $options,
        ])->json());
    }

    /**
     * Force a Sandbox Item into an error state
     *
     * @link https://plaid.com/docs/api/sandbox/#sandboxitemreset_login
     *
     * @param string $accessToken
     * @return ResetItemResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function resetItemLogin(string $accessToken): ResetItemResource
    {
        if ($this->environment !== 'sandbox') {
            throw new RuntimeException('method createPublicToken() only available in sandbox mode.');
        }

        return ResetItemResource::from($this->sendRequest('sandbox/item/reset_login', [
            'access_token' => $accessToken,
        ])->json());
    }

    /**
     * Fire a test webhook.
     *
     * @link https://plaid.com/docs/api/sandbox/#sandboxitemfire_webhook
     *
     * @param string $accessToken
     * @param string $webhookCode
     * @return WebhookFiredResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function fireWebhook(string $accessToken, string $webhookCode = 'DEFAULT_UPDATE'): WebhookFiredResource
    {
        if ($this->environment !== 'sandbox') {
            throw new RuntimeException('method createPublicToken() only available in sandbox mode.');
        }

        if (! in_array($webhookCode, [
            'DEFAULT_UPDATE',
            'NEW_ACCOUNTS_AVAILABLE',
        ])) {
            throw new \http\Exception\InvalidArgumentException("invalid webhook code '$webhookCode'.");
        }

        return WebhookFiredResource::from($this->sendRequest('sandbox/item/fire_webhook', [
            'access_token' => $accessToken,
            'webhook_code' => $webhookCode,
        ])->json());
    }

    /**
     * Create an item for testing.
     *
     * @param string $institution
     * @return AccessTokenResource
     * @throws RequestException
     * @throws InvalidDataClass
     */
    public function createTestItem(string $institution): AccessTokenResource
    {
        $link = $this->createPublicToken($institution);

        return $this->exchangePublicToken($link->public_token);
    }
}
