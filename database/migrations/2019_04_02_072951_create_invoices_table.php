<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->date('invoice_date');
            $table->integer('invoice_number');
            $table->date('invoice_due_date');
            $table->text('invoice_note');
            $table->string('product_name');
            $table->string('product_qty');
            $table->string('product_price');
            $table->string('product_tax');
            $table->string('payment_type');
            $table->float('payment_amount');
            $table->float('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
