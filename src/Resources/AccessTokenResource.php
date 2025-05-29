<?php

namespace CaashApp\Plaid\Resources;

use Spatie\LaravelData\Data;

class AccessTokenResource extends Data
{
    public string $access_token;

    public string $item_id;

    public string $request_id;
}
