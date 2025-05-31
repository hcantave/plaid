<?php

namespace Abivia\Plaid\Tests\Unit;

use Abivia\Plaid\PlaidRequestException;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;

/**
 * @covers \Abivia\Plaid\PlaidRequestException
 *
 * @uses   \Abivia\Plaid\PlaidException
 */
class PlaidRequestExceptionTest extends TestCase
{
    public function test_getting_code_from_exception(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals(404, $plaidRequestException->getCode());
    }

    public function test_getting_display_message_on_exception(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals('Foo not found', $plaidRequestException->getMessage());
    }

    public function test_getting_fallback_message(): void
    {
        $response = new Response(new PsrResponse(404));
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals('HTTP error 404', $plaidRequestException->getMessage());
    }

    public function test_getting_payload_from_exception(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals(
            (object) ['display_message' => 'Foo not found'],
            $plaidRequestException->getBody()
        );
    }
}
