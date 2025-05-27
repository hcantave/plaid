<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Api\Auth;
use Abivia\Plaid\Plaid as PlaidCore;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;


#[CoversClass(\Abivia\Plaid\Plaid::class)]
#[CoversClass(\Abivia\Plaid\Api\AbstractResource::class)]
#[CoversClass(\Abivia\Plaid\Api\Auth::class)]
final class AuthTest extends TestCase
{
    public function testGetAuth(): void
    {
        $psrResponse = new PsrResponse(200, [], '{}');
        Http::shouldReceive('post')
            ->with('auth/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                    'options' => (object)[],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Auth('id', 'secret', '');
        $obj->get('access_token');
    }
}
