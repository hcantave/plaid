<?php

namespace CaashApp\Plaid\Entities;

use CaashApp\Plaid\Casters\DateTimeCaster;
use DateTime;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

#[
    WithCast(DateTime::class, DateTimeCaster::class)
]
class WebhookStatus extends Data
{
    public ?DateTime $sent_at;

    public ?string $code_sent;
}
