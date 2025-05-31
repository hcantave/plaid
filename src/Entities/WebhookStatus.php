<?php

namespace Hcantave\Plaid\Entities;

use DateTime;
use Hcantave\Plaid\Casters\DateTimeCaster;
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
