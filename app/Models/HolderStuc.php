<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolderStuc extends Model
{
    protected $table = 'holder_stuc'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'holder_name',
        'shares_count',
        'share_percentage',
    ];
}
