<?php

namespace Abivia\Plaid\Tests\Unit;

use Abivia\Plaid\Plaid;
use Abivia\Plaid\Tests\TestCase;
use UnexpectedValueException;

/**
 * @covers \Abivia\Plaid\Plaid
 */
class PlaidClientTest extends TestCase
{
    public function test_setting_invalid_environment(): void
    {
        $this->expectException(UnexpectedValueException::class);
        new Plaid('client_id', 'secret', 'invalid_environment');
    }

    public function test_getting_unsupported_resource(): void
    {
        $plaid = new Plaid('client_id', 'secret');

        $this->expectException(UnexpectedValueException::class);
        $plaid->invalidResource();
    }
}
