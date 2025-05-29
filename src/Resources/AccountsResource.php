<?php

namespace Hcantave\Plaid\Resources;

use Hcantave\Plaid\Entities\Account;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AccountsResource extends Data
{
    public function __construct(
        #[DataCollectionOf(Account::class)]
        public DataCollection $accounts,
        public string $request_id,
    ) {}
}
