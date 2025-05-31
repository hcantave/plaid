<?php

namespace Hcantave\Plaid\Entities;

use DateTime;
use Hcantave\Plaid\Casters\DateTimeCaster;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class InvestmentStatus extends Data
{
    public function __construct(
        #[WithCast(DateTimeCaster::class)]
        public ?DateTime $last_successful_update = null,

        #[WithCast(DateTimeCaster::class)]
        public ?DateTime $last_failed_update = null,
    ) {}
}
