<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Threeyear extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางในฐานข้อมูล
    protected $table = 'threeyear';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้ (Mass Assignable)
    protected $fillable = [
        'year',                       // ปี
        'sales_and_services_income',  // รายได้จากการขายและบริการ
        'total_income',               // รายได้รวมทั้งหมด
        'gross_profit',               // กำไร (ขาดทุน) ขั้นต้น
        'ebitda',                     // กำไรก่อนดอกเบี้ย ภาษี ค่าเสื่อมราคา และค่าตัดจำหน่าย (EBITDA)
        'ebit',                       // กำไรก่อนดอกเบี้ยและภาษี (EBIT)
        'net_profit_loss',            // กำไร (ขาดทุน) สุทธิ
        'total_assets',               // สินทรัพย์รวมทั้งหมด
        'total_liabilities',          // หนี้สินรวมทั้งหมด
        'shareholders_equity',        // ส่วนของผู้ถือหุ้น
        'gross_profit_margin',        // อัตรากำไรขั้นต้น (%) (กำไรขั้นต้น/รายได้รวม * 100)
        'ebitda_margin',              // อัตรากำไรก่อนดอกเบี้ย ภาษี ค่าเสื่อมราคา (%) (EBITDA/รายได้รวม * 100)
        'net_profit_margin',          // อัตรากำไรสุทธิ (%) (กำไรสุทธิ/รายได้รวม * 100)
        'return_on_assets',           // อัตราผลตอบแทนจากสินทรัพย์รวม (%) (กำไรสุทธิ/สินทรัพย์รวม * 100)
        'return_on_equity',           // อัตราผลตอบแทนจากส่วนของผู้ถือหุ้น (%) (กำไรสุทธิ/ส่วนของผู้ถือหุ้น * 100)
        'dividend_payout_ratio',      // อัตราเงินปันผลต่อกำไรสุทธิต่อหุ้น (%) (เงินปันผล/กำไรสุทธิต่อหุ้น * 100)
        'dividend_yield',             // อัตราผลตอบแทนจากเงินปันผล (%) (เงินปันผล/มูลค่าหุ้น * 100)
        'current_ratio',              // อัตราส่วนเงินทุนหมุนเวียน (สินทรัพย์หมุนเวียน/หนี้สินหมุนเวียน)
        'debt_to_equity_ratio',       // อัตราส่วนหนี้สินต่อส่วนของผู้ถือหุ้น (หนี้สินรวม/ส่วนของผู้ถือหุ้น)
        'par_value',                  // มูลค่าที่ตราไว้ของหุ้น (บาท)
        'book_value_per_share',       // มูลค่าทางบัญชีต่อหุ้น
        'net_profit_per_share',       // กำไรสุทธิต่อหุ้น
        'dividend_per_share',         // เงินปันผลต่อหุ้น
        'registered_common_shares',   // จำนวนหุ้นสามัญจดทะเบียน (หุ้น)
        'paid_common_shares',         // จำนวนหุ้นสามัญชำระแล้ว (หุ้น)
        'created_at',                 // วันที่สร้างข้อมูล
        'updated_at'                  // วันที่แก้ไขข้อมูลล่าสุด
    ];
    

    // หากมีความจำเป็นต้องตั้งค่า timestamps
    public $timestamps = true;
}
