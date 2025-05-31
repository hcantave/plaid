<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use Abivia\Plaid\Api\Processors;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * @covers \Abivia\Plaid\Plaid
 * @covers \Abivia\Plaid\Api\AbstractResource
 * @covers \Abivia\Plaid\Api\Processors
 */
class ProcessorsTest extends TestCase
{
    public function test_create_dwolla_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/dwolla/processor_token/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                    'account_id' => 'account_id',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->createDwollaToken('access_token', 'account_id');
    }

    public function test_create_stripe_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/stripe/bank_account_token/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                    'account_id' => 'account_id',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->createStripeToken('access_token', 'account_id');
    }

    public function test_create_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/token/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                    'account_id' => 'account_id',
                    'processor' => 'processor',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->createToken('access_token', 'account_id', 'processor');
    }

    public function test_get_auth(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/auth/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'processor_token' => 'processor_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->getAuth('processor_token');
    }

    public function test_get_balance(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/balance/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'processor_token' => 'processor_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->getBalance('processor_token');
    }

    public function test_get_identity(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('processor/identity/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'processor_token' => 'processor_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Processors('id', 'secret', '');
        $obj->getIdentity('processor_token');
    }
}
