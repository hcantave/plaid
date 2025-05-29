<?php

namespace CaashApp\Plaid\Entities;

use Spatie\LaravelData\Data;

class PlaidStatus extends Data
{
    public function __construct(
        public ?InvestmentStatus $investments = null,
        public ?TransactionStatus $transactions = null,
        public ?WebhookStatus $last_webhook = null,
    ) {}
}
