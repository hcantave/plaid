<?php

namespace Hcantave\Plaid\Resources;

use Spatie\LaravelData\Data;

class NewAccessTokenResource extends Data
{
    public string $new_access_token;

    public string $request_id;
}
