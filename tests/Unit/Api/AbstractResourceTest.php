<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use Abivia\Plaid\Api\Items;
use Abivia\Plaid\PlaidRequestException;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

/**
 * @covers \Abivia\Plaid\Plaid
 * @covers \Abivia\Plaid\Api\AbstractResource
 * @covers \Abivia\Plaid\Api\Items
 * @covers \Abivia\Plaid\PlaidRequestException
 */
class AbstractResourceTest extends TestCase
{
    public function test_invalid_json_when_parsing_response(): void
    {
        $psrResponse = new PsrResponse(200, [], 'this is not valid JSON');
        Http::shouldReceive('post')
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();

        $this->expectException(UnexpectedValueException::class);

        $obj = new Items('id', 'secret', '');
        $obj->get('access_token');
    }

    public function test_request_exception_passes_through_http_status_code(): void
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

    public function test_request_exception_passes_through_plaid_display_message(): void
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
