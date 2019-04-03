<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class InvoiceController.
 *
 * @author Jan Arambulo <arambulo@jan.com>
 * @package App\Http\Controllers\Admin
 */
class InvoiceController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::all());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        return view('pages.invoice.index');
    }

    /**
     * @param InvoiceRequest $request
     * @return InvoiceResource
     */
    public function store(InvoiceRequest $request)
    {
        $tax = $request->get('product_tax') / 100;
        $itemCost = $request->get('product_price') + $tax;
        $qtyPrice = $request->get('product_qty') * $itemCost;
        $total = [
            'total' => $request->get('payment_amount') - $qtyPrice,
        ];

        $invoice = Invoice::firstOrCreate(array_merge($request->all(), $total));

        return InvoiceResource::make($invoice);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.invoice.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $propId = $request->route('invoice');

        return view('pages.invoice.edit', compact('propId'));
    }

    /**
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    public function show(Invoice $invoice)
    {
        return InvoiceResource::make($invoice);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request)
    {
        $propId = $request->route('invoice');

        return view('pages.invoice.show', compact('propId'));
    }

    /**
     * @param Request $request
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    public function update(Request $request, Invoice $invoice)
    {
        $tax = $request->get('product_tax') / 100;
        $itemCost = $request->get('product_price') + $tax;
        $qtyPrice = $request->get('product_qty') * $itemCost;
        $total = [
            'total' => $request->get('payment_amount') - $qtyPrice,
        ];
        $invoice->update(array_merge($request->all(), $total));

        return InvoiceResource::make($invoice);
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }
}
