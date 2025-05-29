<?php

namespace CaashApp\Plaid\Casters;

use CaashApp\Plaid\Entities\Account;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class AccountCollectionCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties): mixed
    {
            return collect($value)->map(function ($account): \CaashApp\Plaid\Entities\Account {
                return Account::from($account);
            });
        }
    }
