<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('title'); // ชื่อหัวข้อข่าว
            $table->date('date'); // วันที่ของข่าว
            $table->string('pdf_url')->nullable(); // URL หรือ Path ของ PDF
            $table->timestamps(); // created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
