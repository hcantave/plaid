<?php

namespace Hcantave\Plaid\Resources;

use Spatie\LaravelData\Data;

class ResetItemResource extends Data
{
    public bool $reset_login;

    public string $request_id;
}
