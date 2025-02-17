<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StockPriceP1;

class StockPriceController extends Controller
{
    /**
     * ดึงข้อมูลราคาหุ้นทั้งหมด
     */
    public function all()
    {
        // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
        $stockPrices = StockPriceP1::all();

        // ส่งข้อมูลในรูปแบบ JSON
        return response()->json([
            'status' => 200,
            'data' => $stockPrices,
        ]);
    }

    public function getStockPrices()
{
    $stockPrices = StockPriceP1::all(); // Assuming you are using the StockPriceP1 model
    return response()->json($stockPrices);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'date' => 'required|date',
        'open_price' => 'required|numeric',
        'high_price' => 'required|numeric',
        'low_price' => 'required|numeric',
        'previous_close_price' => 'required|numeric',
        'change' => 'nullable|numeric', // ปรับ change เป็น nullable
        'changepercent' => 'nullable|numeric', // เปลี่ยนเป็น nullable
        'trading_value' => 'required|numeric',
        'trade_amount' => 'nullable|numeric',
    ]);

    // ตั้งค่า default value ถ้าไม่มีการเปลี่ยนแปลง (change)
    $validated['change'] = $validated['change'] ?? 0;
    $validated['changepercent'] = $validated['changepercent'] ?? 0;

    $stockPrice = StockPriceP1::create($validated);

    return response()->json([
        'status' => 201,
        'message' => 'เพิ่มข้อมูลเรียบร้อย',
        'data' => $stockPrice,
    ]);
}

public function update(Request $request, $id)
{
    $stockPrice = StockPriceP1::find($id);

    if (!$stockPrice) {
        return response()->json([
            'status' => 404,
            'message' => 'ไม่พบข้อมูล',
        ]);
    }

    $validated = $request->validate([
        'date' => 'required|date',
        'open_price' => 'required|numeric',
        'high_price' => 'required|numeric',
        'low_price' => 'required|numeric',
        'previous_close_price' => 'required|numeric',
        'change' => 'nullable|numeric', // ปรับเป็น nullable
        'changepercent' => 'nullable|numeric', // ปรับเป็น nullable
        'trading_value' => 'required|numeric',
        'trade_amount' => 'required|numeric',
    ]);

    // ตั้งค่า default value ถ้าไม่มีค่า
    $validated['change'] = $validated['change'] ?? 0;
    $validated['changepercent'] = $validated['changepercent'] ?? 0;

    $stockPrice->update($validated);

    return response()->json([
        'status' => 200,
        'message' => 'แก้ไขข้อมูลเรียบร้อย',
        'data' => $stockPrice,
    ]);
}

public function destroy($id)
{
    // ค้นหาข้อมูลที่ต้องการลบ
    $stockPrice = StockPriceP1::find($id);

    if (!$stockPrice) {
        return response()->json([
            'status' => 404,
            'message' => 'ไม่พบข้อมูล',
        ]);
    }

    // ลบข้อมูล
    $stockPrice->delete();

    return response()->json([
        'status' => 200,
        'message' => 'ลบข้อมูลเรียบร้อย',
    ]);
}


public function getLatest()
{
    $latestStockPrice = StockPriceP1::orderBy('date', 'desc')->first();

    if ($latestStockPrice) {
        return response()->json([
            'status' => 200,
            'data' => $latestStockPrice,
        ]);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'ไม่พบข้อมูล',
        ]);
    }
}


}
