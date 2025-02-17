<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPriceP1 extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางที่ต้องการใช้งาน
    protected $table = 'stock_prices'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'date',
        'open_price',
        'high_price',
        'low_price',
        'previous_close_price',
        'change',
        'changepercent',
        'trading_value',
        'trade_amount',
    ];
}
