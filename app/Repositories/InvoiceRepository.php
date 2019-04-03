<?php

namespace App\Repositories;

use App\Invoice;

/**
 * Class InvoiceRepository.
 *
 * @author Jan Arambulo <arambulo@jan.com>
 * @package App\Repositories
 */
class InvoiceRepository
{
    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * InvoiceRepository constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        $invoice = $this->invoice->create([
            'customer_name'    => $data['customer_name'],
            'customer_address' => $data['customer_address'],
            'invoice_date'     => $data['invoice_date'],
            'invoice_number'   => $data['invoice_number'],
            'invoice_due_date' => $data['invoice_due_date'],
            'invoice_note'     => $data['invoice_note'],
            'product_name'     => $data['product_name'],
            'product_qty'      => $data['product_qty'],
            'product_price'    => $data['product_price'],
            'product_tax'      => $data['product_tax'],
            'payment_type'     => $data['payment_type'],
            'payment_amount'   => $data['payment_amount'],
        ]);

        return $invoice;
    }
}
