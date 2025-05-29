<?php

namespace CaashApp\Plaid\Entities;

use CaashApp\Plaid\Casters\DateTimeCaster;
use DateTime;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Item extends Data
{
    public function __construct(
        public string $item_id,
        public ?string $institution_id = null,
        public ?string $webhook = null,
        public ?Error $error = null,
        public array $available_products = [],
        public array $billed_products = [],
        public array $products = [],
        #[WithCast(DateTimeCaster::class)]
        public ?DateTime $consent_expire_time = null,
        public string $update_type = '',
    ) {}
}
