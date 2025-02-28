<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsprint extends Model
{
    use HasFactory;
    // ระบุชื่อตารางในฐานข้อมูล
    protected $table = 'newsprint';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่ม/แก้ไขได้
    protected $fillable = ['date', 'title', 'title_en', 'pdf_url', 'pdf_url_en'];
}
