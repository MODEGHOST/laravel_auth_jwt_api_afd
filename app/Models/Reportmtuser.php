<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Reportmtuser extends Model
{
    use HasFactory;

    protected $table = 'reportmtuser'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'title',
        'pdf_file',
        
    ];
}
