<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meetinguser extends Model
{
    use HasFactory;

    protected $table = 'meetinguser'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'title',
        'title_en',
        'pdf_file',
        'pdf_file_en',
    ];
}
