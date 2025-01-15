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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('pay_list');
            $table->string('petty_cash_id');
            $table->string('emp_id');
            $table->string('pay_to');
            $table->string('status');
            $table->string('section');
            $table->string('division');
            $table->string('dept');
            $table->string('company');
            $table->string('req_by');
            $table->string('files');
            $table->string('cost_center');
            $table->string('project');
            $table->string('product');
            $table->string('boi');
            $table->string('intercompany');
            $table->string('reserve');
            $table->dateTime('payed_at');
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
        Schema::dropIfExists('petty_cashes');
    }
};
