<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Api\Liabilities;
use Abivia\Plaid\Plaid as PlaidCore;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

#[CoversClass(\Abivia\Plaid\Plaid::class)]
#[CoversClass(\Abivia\Plaid\Api\AbstractResource::class)]
#[CoversClass(\Abivia\Plaid\Api\Liabilities::class)]
final class LiabilitiesTest extends TestCase
{
    public function testGetLiabilities(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('liabilities/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'access_token' => 'access_token',
                    'options' => (object)[],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Liabilities('id', 'secret', '');
        $obj->list('access_token');
    }

}
