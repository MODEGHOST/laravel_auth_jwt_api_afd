<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarterly extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางในฐานข้อมูล
    protected $table = 'quarterly';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้ (Mass Assignable)
    protected $fillable = [
        'quarter', // ไตรมาส
        'sales_and_services_income', // รายได้จากการขายและบริการ
        'total_income', // รายได้รวม
        'gross_profit', // กำไร (ขาดทุน) ขั้นต้น
        'ebitda', // กำไรก่อนดอกเบี้ย ภาษี ค่าเสื่อมราคา และค่าตัดจำหน่าย
        'ebit', // กำไรก่อนดอกเบี้ยและภาษี
        'net_profit_loss', // กำไร (ขาดทุน) สุทธิ
        'total_assets', // สินทรัพย์รวม
        'total_liabilities', // หนี้สินรวม
        'shareholders_equity', // ส่วนของผู้ถือหุ้น
        'gross_profit_margin', // อัตรากำไรขั้นต้น
        'ebitda_margin', // อัตรากำไรก่อนดอกเบี้ย ภาษี ค่าเสื่อมราคา และค่าตัดจำหน่าย
        'net_profit_margin', // อัตรากำไรสุทธิ
        'return_on_assets', // อัตราผลตอบแทนจากสินทรัพย์รวม
        'return_on_equity', // อัตราผลตอบแทนจากส่วนของผู้ถือหุ้น
        'current_ratio', // อัตราส่วนเงินทุนหมุนเวียน
        'debt_to_equity_ratio', // อัตราส่วนหนี้สินต่อส่วนของผู้ถือหุ้น
        'par_value', // มูลค่าที่ตราไว้
        'book_value_per_share', // มูลค่าทางบัญชีต่อหุ้น
        'net_profit_per_share', // กำไรสุทธิต่อหุ้น
        'registered_common_shares', // จำนวนหุ้นสามัญที่จดทะเบียน
        'paid_common_shares', // จำนวนหุ้นสามัญที่ชำระแล้ว
    ];

    // หากมีความจำเป็นต้องตั้งค่า timestamps
    public $timestamps = true;
}
