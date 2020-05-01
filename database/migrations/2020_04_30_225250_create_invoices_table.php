<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{

    const TABLE_NAME = 'invoices';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('invoice_id');
            $table->primary('invoice_id');
            $table->string('client_ip');
            $table->string('email')->index();
            $table->string('type');
            $table->string('address_city');
            $table->string('address_country');
            $table->string('address_line1');
            $table->string('address_zip');
            $table->string('brand');
            $table->string('country');
            $table->string('name');
            $table->integer('total');
            $table->string('last4');
            $table->uuid('user_id')->nullable();
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
