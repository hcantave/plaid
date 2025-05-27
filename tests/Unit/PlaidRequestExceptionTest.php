<?php

namespace Abivia\Plaid\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Abivia\Plaid\PlaidRequestException;
use Abivia\Plaid\Tests\TestCase;
use Abivia\Plaid\Plaid as PlaidCore;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;


#[CoversClass(\Abivia\Plaid\PlaidRequestException::class)]
#[UsesClass('\Abivia\Plaid\PlaidException')]
final class PlaidRequestExceptionTest extends TestCase
{
    public function testGettingCodeFromException(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals(404, $plaidRequestException->getCode());
    }

    public function testGettingDisplayMessageOnException(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals('Foo not found', $plaidRequestException->getMessage());
    }

    public function testGettingFallbackMessage(): void
    {
        $response = new Response(new PsrResponse(404));
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals('HTTP error 404', $plaidRequestException->getMessage());
    }

    public function testGettingPayloadFromException(): void
    {
        $response = new Response(
            new PsrResponse(404, [], '{"display_message": "Foo not found"}')
        );
        $plaidRequestException = new PlaidRequestException($response);

        $this->assertEquals(
            (object)['display_message' => 'Foo not found'],
            $plaidRequestException->getBody()
        );
    }
}
