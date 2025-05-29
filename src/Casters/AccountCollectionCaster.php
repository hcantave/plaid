<?php

namespace Hcantave\Plaid\Casters;

use Hcantave\Plaid\Entities\Account;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class AccountCollectionCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties): mixed
    {
            return collect($value)->map(function ($account): \Hcantave\Plaid\Entities\Account {
                return Account::from($account);
            });
        }
    }
