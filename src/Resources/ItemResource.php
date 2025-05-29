<?php

namespace CaashApp\Plaid\Resources;

use CaashApp\Plaid\Entities\Item;
use CaashApp\Plaid\Entities\PlaidStatus;
use Spatie\LaravelData\Data;

class ItemResource extends Data
{
    public Item $item;

    public ?PlaidStatus $status;

    public string $request_id;
}
