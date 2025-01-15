<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminofgod extends Model
{
    use HasFactory;

    // ชื่อตารางในฐานข้อมูล
    protected $table = 'adminofgod';

    // ฟิลด์ที่อนุญาตให้บันทึกลงในฐานข้อมูลได้
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
}
