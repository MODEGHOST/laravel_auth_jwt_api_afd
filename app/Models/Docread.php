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
        'file_part',
        'qr_code_path',
        'date',
    ];
}
