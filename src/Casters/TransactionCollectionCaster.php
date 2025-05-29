<?php

namespace CaashApp\Plaid\Casters;

use CaashApp\Plaid\Entities\Transaction;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class TransactionCollectionCaster implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties): mixed
    {
        return collect($value)->map(function ($transaction): \CaashApp\Plaid\Entities\Transaction {
            return Transaction::from(array_merge($transaction, [
                'amount' => $this->parseMoney($transaction, 'amount'),
            ]));
        });
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
