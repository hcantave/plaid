<?php

namespace Hcantave\Plaid\Casters;

use DateTime;
use Exception;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class DateTimeCaster implements Cast
{
    /**
     * @throws Exception
     */
    public function cast(DataProperty $property, mixed $value, array $properties): DateTime
    {
            return new DateTime($value);
        }
    }
