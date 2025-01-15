<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposeagenda extends Model
{
    use HasFactory;

    protected $table = 'proposeagenda';

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้
    protected $fillable = [ 'title', 'pdf_url','date'];
}

