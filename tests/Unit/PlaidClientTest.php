<?php

namespace Abivia\Plaid\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Plaid;
use Abivia\Plaid\Tests\TestCase;
use \UnexpectedValueException;
use ReflectionClass;

#[CoversClass(\Abivia\Plaid\Plaid::class)]
final class PlaidClientTest extends TestCase
{
	public function testSettingInvalidEnvironment(): void
	{
		$this->expectException(UnexpectedValueException::class);
		new Plaid('client_id', 'secret', 'invalid_environment');
	}

	public function testGettingUnsupportedResource(): void
	{
		$plaid = new Plaid('client_id', 'secret');

		$this->expectException(UnexpectedValueException::class);
		$plaid->invalidResource();
	}
}
