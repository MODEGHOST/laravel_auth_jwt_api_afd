<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newselectic extends Model
{
    use HasFactory;

    protected $table = 'newseletic';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้
    protected $fillable = ['date', 'title', 'title_en', 'pdf_url', 'pdf_url_en','posted_day'];
}
