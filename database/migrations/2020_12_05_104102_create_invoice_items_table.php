<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->string('label');
            $table->string('description')->nullable();
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->unsignedBigInteger('item_type_id');
            $table->unsignedBigInteger('tax_rate_id');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('item_type_id')->references('id')->on('item_types');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('invoice_items');
        Schema::enableForeignKeyConstraints();
    }
}
