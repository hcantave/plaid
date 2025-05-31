<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use Abivia\Plaid\Api\Accounts;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;

/**
 * @covers \Abivia\Plaid\Plaid
 * @covers \Abivia\Plaid\Api\AbstractResource
 * @covers \Abivia\Plaid\Api\Accounts
 */
class AccountsTest extends TestCase
{
    public function test_get_accounts(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        $this->mock(Response::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('failed')->andReturn(false);
            }
        );
        Http::shouldReceive('post')
            ->with('accounts/get', [
                'client_id' => 'id',
                'secret' => 'secret',
                'access_token' => 'access_token',
                'options' => (object) [],
            ])
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Accounts('id', 'secret', '');
        $obj->list('access_token');
    }

    public function test_get_balance(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('accounts/balance/get', [
                'client_id' => 'id',
                'secret' => 'secret',
                'access_token' => 'access_token',
                'options' => (object) [],
            ])
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Accounts('id', 'secret', '');
        $obj->getBalance('access_token');
    }

    public function test_get_identity(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('identity/get', [
                'client_id' => 'id',
                'secret' => 'secret',
                'access_token' => 'access_token',
                'options' => (object) [],
            ])
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Accounts('id', 'secret', '');
        $obj->getIdentity('access_token');
    }
}
