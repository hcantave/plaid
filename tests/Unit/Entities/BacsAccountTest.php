<?php
namespace Abivia\Plaid\Tests\Unit\Entities;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Entities\BacsAccount;
use Abivia\Plaid\Tests\TestCase;

#[CoversClass(\Abivia\Plaid\Entities\BacsAccount::class)]
class BacsAccountTest extends TestCase
{
	public function testConstructorSetsAccountAndSortCode(): void
	{
		$bacsAccount = new BacsAccount('account', 'sort_code');

		$this->assertEquals(
			[
				'account' => 'account',
				'sort_code' => 'sort_code'
			],
			$bacsAccount->toArray()
		);
	}
}
