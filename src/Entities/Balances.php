<?php

namespace Hcantave\Plaid\Entities;

use Carbon\Carbon;
use Money\Money;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class Balances extends Data
{
    public function __construct(
        public ?Money $available,
        public ?Money $current,
        public ?Money $limit,
        public ?string $iso_currency_code,
        public ?string $unofficial_currency_code,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $last_updated_datetime,
    ) {}
}
