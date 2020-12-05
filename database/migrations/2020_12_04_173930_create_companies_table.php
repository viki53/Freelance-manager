<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->unsignedBigInteger('owner_id');
            $table->uuid('headquarters_address_id')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('headquarters_address_id')->references('id')->on('addresses');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->uuid('company_id')->after('id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('companies');
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_company_id_foreign');
            $table->dropColumn('company_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
