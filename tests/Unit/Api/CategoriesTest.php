<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Api\Categories;
use Abivia\Plaid\Plaid as PlaidCore;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

#[CoversClass(\Abivia\Plaid\Plaid::class)]
#[CoversClass(\Abivia\Plaid\Api\AbstractResource::class)]
#[CoversClass(\Abivia\Plaid\Api\Categories::class)]
class CategoriesTest extends TestCase
{
    public function testGetIdentity(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('categories/get',
                []
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Categories('id', 'secret', '');
        $obj->list();
    }
}
