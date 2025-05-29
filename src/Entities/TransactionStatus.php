<?php

namespace CaashApp\Plaid\Entities;

use CaashApp\Plaid\Casters\DateTimeCaster;
use DateTime;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class TransactionStatus extends Data
{
    public function __construct(
        #[WithCast(DateTimeCaster::class)]
        public ?DateTime $last_successful_update = null,
        
        #[WithCast(DateTimeCaster::class)]
        public ?DateTime $last_failed_update = null,
    ) {}
}
