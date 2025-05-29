<?php

namespace Hcantave\Plaid\Casters;

use Hcantave\Plaid\Entities\Balances;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class BalanceCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties): mixed
    {
        return Balances::from([
            'available' => $this->parseMoney($value, 'available'),
            'current' => $this->parseMoney($value, 'current'),
            'limit' => $this->parseMoney($value, 'limit'),
            'iso_currency_code' => $value['iso_currency_code'] ?? null,
            'unofficial_currency_code' => $value['unofficial_currency_code'] ?? null,
            'last_updated_datetime' => $value['last_updated_datetime'] ?? null,
        ]);
    }
    protected function parseMoney(mixed $value, string $key): ?Money
    {
        if (! isset($value[$key]) || is_null($value[$key])) {
            return null;
        }

        $currencyCode = $value['iso_currency_code'] ?? $value['unofficial_currency_code'];
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return $moneyParser->parse((string) $value[$key], new Currency($currencyCode));
    }
}
