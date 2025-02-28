<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'date',
        'title',
        'title_en',
        'description',
        'description_en',
    ];
}
