<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use PHPUnit\Framework\Attributes\CoversClass;
use Abivia\Plaid\Api\Items;
use Abivia\Plaid\Plaid;
use Abivia\Plaid\Plaid as PlaidCore;
use Abivia\Plaid\PlaidRequestException;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

#[CoversClass(\Abivia\Plaid\Plaid::class)]
#[CoversClass(\Abivia\Plaid\Api\AbstractResource::class)]
#[CoversClass(\Abivia\Plaid\Api\Items::class)]
#[CoversClass(\Abivia\Plaid\PlaidRequestException::class)]
final class AbstractResourceTest extends TestCase
{
    public function testInvalidJsonWhenParsingResponse(): void
    {
        $psrResponse = new PsrResponse(200, [], 'this is not valid JSON');
        Http::shouldReceive('post')
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();

        $this->expectException(UnexpectedValueException::class);

        $obj = new Items('id', 'secret', '');
        $obj->get('access_token');
    }

    public function testRequestExceptionPassesThroughHttpStatusCode(): void
    {
        $psrResponse = new PsrResponse(300, [], '{"display_message": "DISPLAY MESSAGE"}');
        Http::shouldReceive('post')
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();

        try {
            $obj = new Items('id', 'secret', '');
            $obj->get('access_token');
        } catch (PlaidRequestException $plaidRequestException) {

            $this->assertEquals(300, $plaidRequestException->getCode());

        }
    }

    public function testRequestExceptionPassesThroughPlaidDisplayMessage(): void
    {
        $psrResponse = new PsrResponse(300, [], '{"display_message": "DISPLAY MESSAGE"}');
        Http::shouldReceive('post')
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();

        try {
            $obj = new Items('id', 'secret', '');
            $obj->get('access_token');
        } catch (PlaidRequestException $ex) {
            $this->assertEquals('DISPLAY MESSAGE', $ex->getMessage());
        }
    }
}
