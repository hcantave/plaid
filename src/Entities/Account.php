<?php

namespace CaashApp\Plaid\Entities;

use Spatie\LaravelData\Data;

class Account extends Data
{
    public function __construct(
        public string $account_id,
        public Balances $balances,
        public ?string $mask,
        public string $name,
        public ?string $official_name,
        public string $type,
        public ?string $subtype,
        public ?string $verification_status,
    ) {}
}
