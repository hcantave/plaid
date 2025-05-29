<?php

namespace CaashApp\Plaid\Entities;

use Carbon\Carbon;
use Money\Money;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class Transaction extends Data
{
    public function __construct(
        /** @deprecated Please use the payment_channel field */
        public string $transaction_type,
        public ?string $pending_transaction_id,
        public ?string $category_id,
        public ?array $category,
        public array $location,
        public array $payment_meta,
        public ?string $account_owner,
        public string $name,
        public ?string $original_description,
        public string $account_id,
        public Money $amount,
        public ?string $iso_currency_code,
        public ?string $unofficial_currency_code,
        #[WithCast(DateTimeInterfaceCast::class)]
        public Carbon $date,
        public bool $pending,
        public string $transaction_id,
        public ?string $merchant_name,
        public ?int $check_number,
        public string $payment_channel,
        public ?Carbon $authorized_date,
        public ?Carbon $authorized_datetime,
        public ?Carbon $datetime,
        public ?string $transaction_code,
        public ?array $personal_finance_category,
    ) {}
}
