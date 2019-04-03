<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name'    => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'invoice_date'     => 'required|date',
            'invoice_number'   => 'required|integer',
            'invoice_due_date' => 'required|date',
            'invoice_note'     => 'required|string',
            'product_name'     => 'required|string',
            'product_qty'      => 'required|integer',
            'product_price'    => 'required',
            'product_tax'      => 'required|integer',
            'payment_type'     => 'required|string',
            'payment_amount'   => 'required',
        ];
    }
}
