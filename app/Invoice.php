<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'invoices';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'customer_name',
        'customer_address',
        'invoice_date',
        'invoice_number',
        'invoice_due_date',
        'invoice_note',
        'product_name',
        'product_qty',
        'product_price',
        'product_tax',
        'payment_type',
        'payment_amount',
        'total'
    ];

    public function getFormattedInvoiceDateAttribute()
    {
        return Carbon::make($this->invoice_date)->format('F j, Y');
    }

    public function getFormattedInvoiceDueDateAttribute()
    {
        return Carbon::make($this->invoice_due_date)->format('F j, Y');
    }
}
