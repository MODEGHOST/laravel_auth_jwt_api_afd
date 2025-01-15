<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_prices', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('open_price', 10, 2);
            $table->decimal('high_price', 10, 2);
            $table->decimal('low_price', 10, 2);
            $table->decimal('previous_close_price', 10, 2);
            $table->string('change');
            $table->string('changepercent');
            $table->bigInteger('trading_value');
            $table->timestamps(); // เพิ่ม created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_prices');
    }
}
