<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้
    protected $fillable = ['date', 'title', 'title_en', 'pdf_url', 'pdf_url_en'];
}

