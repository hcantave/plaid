<?php

namespace CaashApp\Plaid\Resources;

use CaashApp\Plaid\Entities\Institution;
use Spatie\LaravelData\Data;

class InstitutionResource extends Data
{
    public Institution $institution;

    public string $request_id;
}
