<?php

namespace Hcantave\Plaid\Resources;

use Hcantave\Plaid\Entities\Item;
use Hcantave\Plaid\Entities\PlaidStatus;
use Spatie\LaravelData\Data;

class ItemResource extends Data
{
    public Item $item;

    public ?PlaidStatus $status;

    public string $request_id;
}
