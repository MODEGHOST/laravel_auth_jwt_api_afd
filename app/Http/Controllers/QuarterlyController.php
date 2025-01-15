<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quarterly;

class QuarterlyController extends Controller
{
    /**
     * ดึงข้อมูลทั้งหมด
     */
    public function index()
    {
        $data = Quarterly::all();

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    /**
     * ดึงข้อมูลตาม ID
     */
    public function show($id)
    {
        $data = Quarterly::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }

    /**
     * เพิ่มข้อมูลใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quarter' => 'required|string',
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
            'current_ratio' => 'required|numeric',
            'debt_to_equity_ratio' => 'required|numeric',
            'par_value' => 'required|numeric',
            'book_value_per_share' => 'required|numeric',
            'net_profit_per_share' => 'required|numeric',
            'registered_common_shares' => 'required|numeric',
            'paid_common_shares' => 'required|numeric',
        ]);

        $data = Quarterly::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'เพิ่มข้อมูลเรียบร้อย',
            'data' => $data,
        ]);
    }

    /**
     * อัปเดตข้อมูล
     */
    public function update(Request $request, $id)
    {
        $data = Quarterly::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        $validated = $request->validate([
            'quarter' => 'required|string',
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
            'current_ratio' => 'required|numeric',
            'debt_to_equity_ratio' => 'required|numeric',
            'par_value' => 'required|numeric',
            'book_value_per_share' => 'required|numeric',
            'net_profit_per_share' => 'required|numeric',
            'registered_common_shares' => 'required|numeric',
            'paid_common_shares' => 'required|numeric',
        ]);

        $data->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'แก้ไขข้อมูลเรียบร้อย',
            'data' => $data,
        ]);
    }

    /**
     * ลบข้อมูล
     */
    public function destroy($id)
    {
        $data = Quarterly::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        $data->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ลบข้อมูลเรียบร้อย',
        ]);
    }
}
