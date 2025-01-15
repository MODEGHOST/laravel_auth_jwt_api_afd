<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detailgeneration extends Model
{
    protected $table = 'detailgeneration'; // ชื่อตารางในฐานข้อมูล
    protected $fillable = [
        'title', 
        'year', 
        'description', 
        'quater', 
        'pdf_url'
    ];

    public $timestamps = true; // เปิดใช้งาน created_at และ updated_at
}
