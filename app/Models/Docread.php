<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docread extends Model
{
    use HasFactory;
    protected $table = 'doc_read'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'title',
        'title_en',
        'file_path',
        'file_path_en',
        'qr_code_path',
        'date',
    ];
}
