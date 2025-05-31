<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use Abivia\Plaid\Api\Items;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * @covers \Abivia\Plaid\Plaid
 * @covers \Abivia\Plaid\Api\AbstractResource
 * @covers \Abivia\Plaid\Api\Items
 */
class ItemsTest extends TestCase
{
    public function test_create_public_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('item/public_token/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->createPublicToken('access_token');
    }

    public function test_exchange_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('item/public_token/exchange',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'public_token' => 'public_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->exchangeToken('public_token');
    }

    public function test_get_income(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('income/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->getIncome('access_token');
    }

    public function test_get_items(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('item/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->get('access_token');
    }

    public function test_remove_item(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('item/remove',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->remove('access_token');
    }

    public function test_rotate_access_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('item/access_token/invalidate',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Items('id', 'secret', '');
        $obj->rotateAccessToken('access_token');
    }
}
