<?php

namespace CaashApp\Plaid\Entities;

use Spatie\LaravelData\Data;

class Institution extends Data
{
    public function __construct(
        public string $institution_id,
        public string $name,
        public array $products,
        public array $country_codes,
        public ?string $url = null,
        public ?string $primary_color = null,
        public ?string $logo = null,
        public array $routing_numbers = [],
        public bool $oauth = false,
        public ?array $status = null,
        public ?array $payment_initiation_metadata = null,
        public ?array $auth_metadata = null,
    ) {}
}
