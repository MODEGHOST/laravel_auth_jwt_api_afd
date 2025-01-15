<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pay_list_id');
            $table->string('acc_id');
            $table->string('invoice_id');
            $table->integer('pay_vat');
            $table->string('pay_type');
            $table->string('description');
            $table->integer('amount');
            $table->integer('total');
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
        Schema::dropIfExists('pay_lists');
    }
};
