<?php

namespace Hcantave\Plaid\Resources;

use DateTime;
use Hcantave\Plaid\Casters\DateTimeCaster;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

#[
    WithCast(DateTime::class, DateTimeCaster::class)
]
class LinkTokenResource extends Data
{
    public string $link_token;

    public DateTime $expiration;

    public string $request_id;

    public function isExpired(): bool
    {
        return $this->expiration < new DateTime;
    }
}
