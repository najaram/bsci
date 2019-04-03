<?php

namespace Tests\Feature\Controller;

use App\Invoice;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Http\Controllers\Admin\InvoiceController;

/**
 * Class InvoiceControllerTest.
 *
 * @covers \App\Http\Controllers\Admin\InvoiceController
 * @method InvoiceController make()
 *
 * @author Jan Arambulo <arambulo.jan@gmail.com>
 * @package Tests\Feature\Controller
 */
class InvoiceControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $className = InvoiceController::class;

    private function validateParams(array $overrides = [])
    {
        return array_merge([
            'customer_name'    => 'updated example name',
            'customer_address' => 'updated example address',
            'invoice_date'     => Carbon::now()->format('Y-m-d'),
            'invoice_number'   => 1,
            'invoice_due_date' => Carbon::now()->format('Y-m-d'),
            'invoice_note'     => 'example note',
            'product_name'     => 'example product name',
            'product_qty'      => 1,
            'product_price'    => 1,
            'product_tax'      => 2,
            'payment_type'     => 'cash',
            'payment_amount'   => 100,
        ], $overrides);
    }

    public function testStore()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->post('/invoice', [
                'customer_name'    => 'example name',
                'customer_address' => 'example address',
                'invoice_date'     => Carbon::now()->format('Y-m-d'),
                'invoice_number'   => 1,
                'invoice_due_date' => Carbon::now()->format('Y-m-d'),
                'invoice_note'     => 'example note',
                'product_name'     => 'example product name',
                'product_qty'      => 1,
                'product_price'    => 1,
                'product_tax'      => 2,
                'payment_type'     => 'cash',
                'payment_amount'   => 100,
        ]);

        $data = json_decode($response->getContent(), true);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'customer_name'    => 'example name',
                'customer_address' => 'example address',
            ],
        ]);
        $this->assertEquals('example name', $data['data']['customer_name']);
        $this->assertEquals('example address', $data['data']['customer_address']);
    }

    public function testUpdate()
    {
        $invoice = factory(Invoice::class)->create([
            'customer_name' => 'example name',
            'customer_address' => 'example address'
        ]);

        $response = $this->actingAs(factory(User::class)->create())
            ->put("/invoice/{$invoice->id}", $this->validateParams());
        $data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'customer_name'    => 'updated example name',
                'customer_address' => 'updated example address',
            ]
        ]);
        $this->assertEquals('updated example name', $data['data']['customer_name']);
        $this->assertEquals('updated example address', $data['data']['customer_address']);
    }
}
