<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarandyear extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางในฐานข้อมูล
    protected $table = 'quarandyear';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้ (Mass Assignable)
    protected $fillable = [
        'Qpercent',
        'Ypercent',
    ];

    // หากมีความจำเป็นต้องตั้งค่า timestamps
    public $timestamps = true;
}
