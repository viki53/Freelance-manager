<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->uuid('customer_id')->after('company_id')->nullable();

            $table->foreign('customer_id')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
