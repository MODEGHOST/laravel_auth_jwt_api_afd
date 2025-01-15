<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsmarketsTable extends Migration
{
    public function up()
    {
        Schema::create('newsmarkets', function (Blueprint $table) {
            $table->id();
            $table->string('date'); // วันที่
            $table->string('title'); // หัวข้อข่าว
            $table->string('pdf_url'); // ลิงก์ไฟล์ PDF
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsmarkets');
    }
}
