<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => (int)$this->id,
            'customer_name'    => $this->customer_name,
            'customer_address' => $this->customer_address,
            'invoice_date'     => $this->formatted_invoice_date,
            'invoice_number'   => $this->invoice_number,
            'invoice_due_date' => $this->formatted_invoice_due_date,
            'invoice_note'     => $this->invoice_note,
            'product_name'     => $this->product_name,
            'product_qty'      => (int)$this->product_qty,
            'product_price'    => (float)$this->product_price,
            'product_tax'      => (int)$this->product_tax,
            'payment_type'     => $this->payment_type,
            'payment_amount'   => $this->payment_amount,
            'total'            => $this->total,
        ];
    }
}
