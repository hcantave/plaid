<?php

namespace CaashApp\Plaid\Resources;

use Spatie\LaravelData\Data;

class WebhookFiredResource extends Data
{
    public bool $webhook_fired;

    public string $request_id;
}
