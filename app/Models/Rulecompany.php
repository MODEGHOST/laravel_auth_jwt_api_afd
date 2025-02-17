<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rulecompany  extends Model
{
    use HasFactory;

    protected $table = 'rulecompany';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้
    protected $fillable = ['date', 'title', 'pdf_url','date'];
}

