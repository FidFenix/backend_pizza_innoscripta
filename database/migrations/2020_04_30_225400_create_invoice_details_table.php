<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{

    const TABLE_NAME = 'invoice_details';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('invoicedetail_id');
            $table->primary('invoicedetail_id');
            $table->string('id');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('imageUrl');
            $table->string('name');
            $table->uuid('invoice_id');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::TABLE_NAME);
    }
}
