<?php

namespace Hcantave\Plaid\Facades;

use DateTime;
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
use Illuminate\Support\Facades\Facade;

/**
 * @method static LinkTokenResource createLinkToken(string $userId, array $options = [])
 * @method static LinkTokenResource updateLinkToken(string $userId, string $accessToken, array $options = [])
 * @method static AccessTokenResource exchangePublicToken(string $publicToken)
 * @method static ItemResource getItem(string $accessToken)
 * @method static ItemResource updateWebhook(string $accessToken, string $webhook)
 * @method static ItemRemoveResource removeItem(string $accessToken)
 * @method static InstitutionCollectionResource listInstitutions(int $count, int $offset, array $options = [])
 * @method static InstitutionResource getInstitution(string $institutionId, array $options = [])
 * @method static InstitutionResource searchInstitutions(string $query, array $options = [])
 * @method static AccountsResource getAccounts(string $accessToken)
 * @method static NewAccessTokenResource rotateAccessToken(string $accessToken)
 * @method static PublicTokenResource createPublicToken(string $institutionId, array $options = null)
 * @method static ResetItemResource resetItemLogin(string $accessToken)
 * @method static WebhookFiredResource fireWebhook(string $accessToken, string $webhookCode = 'DEFAULT_UPDATE')
 * @method static AccessTokenResource createTestItem(string $institution)
 * @method static TransactionsResource fetchTransactions(string $itemId, DateTime $startDate, DateTime $endDate);
 *
 * @see \Hcantave\Plaid\Client\Factory
 */
class Plaid extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'plaid';
    }
}
