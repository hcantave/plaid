<?php

namespace CaashApp\Plaid\Entities;

use Spatie\LaravelData\Data;

class Error extends Data
{
    public function __construct(
        public string $error_type,
        public string $error_code,
        public string $error_message,
        public ?string $display_message = null,
        public ?string $request_id = null,
        public ?array $causes = null,
        public ?int $status = null,
        public ?string $documentation_url = null,
        public ?string $suggested_action = null,
    ) {}
}
