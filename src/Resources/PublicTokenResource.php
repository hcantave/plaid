<?php

namespace Hcantave\Plaid\Resources;

use Spatie\LaravelData\Data;

class PublicTokenResource extends Data
{
    public string $public_token;

    public string $request_id;
}
