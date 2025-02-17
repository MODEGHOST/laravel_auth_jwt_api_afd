<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Threeyear;
use Illuminate\Support\Facades\DB;

class ThreeyearController extends Controller
{
    /**
     * ดึงข้อมูลทั้งหมดพร้อม Comment
     */
    public function index()
    {
        // ดึงข้อมูลทั้งหมดจากตาราง threeyear
        $data = Threeyear::all();

        // ดึง Comment ของคอลัมน์จากตาราง threeyear
        $comments = $this->getColumnComments('threeyear');

        return response()->json([
            'status' => 200,
            'data' => $data,
            'comments' => $comments, // ส่ง Comment ไปใช้ใน Frontend
        ]);
    }

    /**
     * ดึงข้อมูลตาม ID พร้อม Comment
     */
    public function show($id)
    {
        // ค้นหาข้อมูลตาม ID
        $data = Threeyear::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        // ดึง Comment ของคอลัมน์จากตาราง threeyear
        $comments = $this->getColumnComments('threeyear');

        return response()->json([
            'status' => 200,
            'data' => $data,
            'comments' => $comments, // ส่ง Comment ไปด้วย
        ]);
    }

    /**
     * เพิ่มข้อมูลใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $validated = $request->validate([
            'year' => 'required|integer',
            'sales_and_services_income' => 'required|numeric',
            'total_income' => 'required|numeric',
            'gross_profit' => 'required|numeric',
            'ebitda' => 'required|numeric',
            'ebit' => 'required|numeric',
            'net_profit_loss' => 'required|numeric',
            'total_assets' => 'required|numeric',
            'total_liabilities' => 'required|numeric',
            'shareholders_equity' => 'required|numeric',
            'gross_profit_margin' => 'required|numeric',
            'ebitda_margin' => 'required|numeric',
            'net_profit_margin' => 'required|numeric',
            'return_on_assets' => 'required|numeric',
            'return_on_equity' => 'required|numeric',
            'dividend_payout_ratio' => 'required|numeric',
            'dividend_yield' => 'required|numeric',
            'current_ratio' => 'required|numeric',
            'debt_to_equity_ratio' => 'required|numeric',
            'par_value' => 'required|numeric',
            'book_value_per_share' => 'required|numeric',
            'net_profit_per_share' => 'required|numeric',
            'dividend_per_share' => 'required|numeric',
            'registered_common_shares' => 'required|numeric',
            'paid_common_shares' => 'required|numeric',
        ]);

        // สร้างข้อมูลใหม่
        $data = Threeyear::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'เพิ่มข้อมูลเรียบร้อย',
            'data' => $data,
        ]);
    }

    /**
     * อัปเดตข้อมูล
     */
    public function update(Request $request, $id = null)
    {
        if ($id) {
            // ค้นหาข้อมูลตาม ID
            $data = Threeyear::find($id);
    
            if (!$data) {
                return response()->json([
                    'status' => 404,
                    'message' => 'ไม่พบข้อมูล',
                ]);
            }
    
            // ตรวจสอบความถูกต้องของข้อมูล
            $validated = $request->validate([
                'year' => 'required|integer',
                'sales_and_services_income' => 'required|numeric',
                'total_income' => 'required|numeric',
                'gross_profit' => 'required|numeric',
                'ebitda' => 'required|numeric',
                'ebit' => 'required|numeric',
                'net_profit_loss' => 'required|numeric',
                'total_assets' => 'required|numeric',
                'total_liabilities' => 'required|numeric',
                'shareholders_equity' => 'required|numeric',
                'gross_profit_margin' => 'required|numeric',
                'ebitda_margin' => 'required|numeric',
                'net_profit_margin' => 'required|numeric',
                'return_on_assets' => 'required|numeric',
                'return_on_equity' => 'required|numeric',
                'dividend_payout_ratio' => 'required|numeric',
                'dividend_yield' => 'required|numeric',
                'current_ratio' => 'required|numeric',
                'debt_to_equity_ratio' => 'required|numeric',
                'par_value' => 'required|numeric',
                'book_value_per_share' => 'required|numeric',
                'net_profit_per_share' => 'required|numeric',
                'dividend_per_share' => 'required|numeric',
                'registered_common_shares' => 'required|numeric',
                'paid_common_shares' => 'required|numeric',
            ]);
    
            // อัปเดตข้อมูล
            $data->update($validated);
    
            return response()->json([
                'status' => 200,
                'message' => 'แก้ไขข้อมูลเรียบร้อย',
                'data' => $data,
            ]);
        }
    
        // ตรวจสอบว่ามีการอัปเดต comment หรือไม่
        if ($request->has('comments')) {
            $comments = $request->input('comments');
    
            foreach ($comments as $column => $comment) {
                try {
                    // ดึงประเภทของคอลัมน์จากฐานข้อมูล
                    $columnDetails = DB::select("SHOW COLUMNS FROM threeyear WHERE Field = ?", [$column]);
            
                    if (empty($columnDetails)) {
                        return response()->json([
                            'status' => 400,
                            'message' => "Column '$column' does not exist.",
                        ], 400);
                    }
            
                    $columnType = $columnDetails[0]->Type;
            
                    // ใช้ string concatenation แทน parameter binding
                    $sql = "ALTER TABLE threeyear MODIFY `$column` $columnType COMMENT '" . addslashes($comment) . "'";
                    DB::statement($sql);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Error updating comment: ' . $e->getMessage(),
                    ], 500);
                }
            }
            
    
            return response()->json([
                'status' => 200,
                'message' => 'อัปเดต Comment สำเร็จ',
            ]);
        }
    
        return response()->json([
            'status' => 400,
            'message' => 'กรุณาระบุข้อมูลที่ต้องการอัปเดต',
        ], 400);
    }
    
    
    

    /**
     * ลบข้อมูล
     */
    public function destroy($id)
    {
        // ค้นหาข้อมูลตาม ID
        $data = Threeyear::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        // ลบข้อมูล
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลเรียบร้อย',
        ]);
    }

    /**
     * ฟังก์ชันสำหรับดึง Comment ของแต่ละคอลัมน์ในตาราง
     * @param string $tableName
     * @return \Illuminate\Support\Collection
     */
    private function getColumnComments($tableName)
    {
        return DB::table('information_schema.COLUMNS')
            ->select('COLUMN_NAME', 'COLUMN_COMMENT')
            ->where('TABLE_SCHEMA', env('DB_DATABASE')) // ใช้ชื่อฐานข้อมูลจาก .env
            ->where('TABLE_NAME', $tableName)
            ->pluck('COLUMN_COMMENT', 'COLUMN_NAME'); // คืนค่าในรูปแบบ Key-Value
    }
}
