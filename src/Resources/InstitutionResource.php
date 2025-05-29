<?php

namespace Hcantave\Plaid\Resources;

use Hcantave\Plaid\Entities\Institution;
use Spatie\LaravelData\Data;

class InstitutionResource extends Data
{
    public Institution $institution;

    public string $request_id;
}
