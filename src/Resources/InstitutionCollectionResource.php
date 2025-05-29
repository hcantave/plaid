<?php

namespace CaashApp\Plaid\Resources;

use CaashApp\Plaid\Entities\Institution;
use Spatie\LaravelData\Data;

class InstitutionCollectionResource extends Data
{
    /** @var Institution[] */
    public array $institutions;

    public ?int $total;

    public string $request_id;
}
