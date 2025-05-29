<?php

namespace Hcantave\Plaid\Resources;

use Hcantave\Plaid\Casters\AccountCollectionCaster;
use Hcantave\Plaid\Casters\TransactionCollectionCaster;
use Hcantave\Plaid\Entities\Account;
use Hcantave\Plaid\Entities\Item;
use Hcantave\Plaid\Entities\Transaction;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\LaravelData\Data;

class TransactionsResource extends Data
{
    /** @var Collection<Account> */
    #[CastWith(AccountCollectionCaster::class)]
    public Collection $accounts;

    /** @var Collection<Transaction> */
    #[CastWith(TransactionCollectionCaster::class)]
    public Collection $transactions;

    public int $total_transactions;

    public Item $item;
}
