<?php

namespace Abivia\Plaid\Tests\Unit\Api;

use Abivia\Plaid\Api\Payments;
use Abivia\Plaid\Entities\BacsAccount;
use Abivia\Plaid\Entities\PaymentSchedule;
use Abivia\Plaid\Entities\RecipientAddress;
use Abivia\Plaid\Tests\TestCase;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * @covers \Abivia\Plaid\Plaid
 * @covers \Abivia\Plaid\Api\AbstractResource
 * @covers \Abivia\Plaid\Api\Payments
 * @covers \Abivia\Plaid\Entities\RecipientAddress
 * @covers \Abivia\Plaid\Entities\PaymentSchedule
 * @covers \Abivia\Plaid\Entities\BacsAccount
 */
class PaymentsTest extends TestCase
{
    public function test_create_payment(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/payment/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'recipient_id' => 'rcp_1234',
                    'reference' => 'ref_5678',
                    'amount' => [
                        'value' => '250.25',
                        'currency' => 'GBP',
                    ],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->create('rcp_1234', 'ref_5678', 250.25, 'GBP');
    }

    public function test_create_payment_token(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/payment/token/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'payment_id' => 'pmt_1234',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->createToken('pmt_1234');
    }

    public function test_create_payment_with_schedule(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/payment/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'recipient_id' => 'rcp_1234',
                    'reference' => 'ref_5678',
                    'amount' => [
                        'value' => '250.25',
                        'currency' => 'GBP',
                    ],
                    'schedule' => [
                        'interval' => 'MONTHLY',
                        'interval_execution_day' => 15,
                        'start_date' => '2020-10-15',
                    ],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->create(
            'rcp_1234',
            'ref_5678',
            250.25,
            'GBP',
            new PaymentSchedule(
                PaymentSchedule::INTERVAL_MONTHLY,
                15,
                new Carbon('2020-10-15')
            )
        );
    }

    public function test_create_recipient(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/recipient/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'name' => 'name',
                    'address' => (object) [
                        'street' => [
                            0 => '139 The Esplanade',
                        ],
                        'city' => 'Weymouth',
                        'postal_code' => 'DT4 7NR',
                        'country' => 'GB',
                    ],
                    'iban' => 'iban',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->createRecipient(
            'name',
            'iban',
            new RecipientAddress(
                '139 The Esplanade', null, 'Weymouth',
                'DT4 7NR', 'GB'
            )
        );
    }

    public function test_create_recipient_with_bacs_account_entity(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/recipient/create',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'name' => 'name',
                    'address' => (object) [
                        'street' => [
                            0 => '139 The Esplanade',
                        ],
                        'city' => 'Weymouth',
                        'postal_code' => 'DT4 7NR',
                        'country' => 'GB',
                    ],
                    'bacs' => [
                        'account' => 'account',
                        'sort_code' => 'sort_code',
                    ],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->createRecipient(
            'name',
            new BacsAccount('account', 'sort_code'),
            new RecipientAddress(
                '139 The Esplanade',
                null,
                'Weymouth',
                'DT4 7NR',
                'GB'
            )
        );
    }

    public function test_get_payment(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/payment/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'payment_id' => 'pmt_1234',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->get('pmt_1234');
    }

    public function test_get_recipient(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/recipient/get',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'recipient_id' => 'rcp_1234',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->getRecipient('rcp_1234');
    }

    public function test_list_payments(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/payment/list',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                    'options' => (object) [],
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->list();
    }

    public function test_list_recipients(): void
    {
        $psrResponse = (new PsrResponse(200, [], '{}'));
        Http::shouldReceive('post')
            ->with('payment_initiation/recipient/list',
                [
                    'client_id' => 'id',
                    'secret' => 'secret',
                ]
            )
            ->andReturn(new Response($psrResponse));
        $this->expectPlaidHeader();
        $obj = new Payments('id', 'secret', '');
        $obj->listRecipients();
    }
}
