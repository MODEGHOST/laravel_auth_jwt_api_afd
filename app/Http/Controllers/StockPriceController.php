<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StockPriceP1;
use Illuminate\Support\Facades\Validator;

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


public function importCSV(Request $request)
{
    if (!$request->hasFile('file')) {
        return response()->json([
            'status' => 400,
            'message' => 'กรุณาอัปโหลดไฟล์ CSV',
        ]);
    }

    $file = $request->file('file');

    if ($file->getClientOriginalExtension() != 'csv') {
        return response()->json([
            'status' => 400,
            'message' => 'ไฟล์ต้องเป็น CSV เท่านั้น',
        ]);
    }

    // อ่านไฟล์ CSV
    $data = array_map('str_getcsv', file($file->getRealPath()));

    if (count($data) <= 1) {
        return response()->json([
            'status' => 400,
            'message' => 'ไฟล์ CSV ไม่มีข้อมูล',
        ]);
    }

    // ดึงหัวข้อของไฟล์ CSV
    $header = array_map('trim', $data[0]);
    unset($data[0]); // ลบหัวข้อออกจากข้อมูลหลัก

    $imported = 0;
    foreach ($data as $row) {
        if (count($row) != count($header)) {
            continue;
        }

        // จัดรูปแบบข้อมูลให้อยู่ใน key-value ตาม header
        $stockData = array_combine($header, array_map('trim', $row));

        // แปลงวันที่ให้เป็น ค.ศ. ถ้าพบ พ.ศ.
        if (preg_match('/25\d{2}/', $stockData['date'])) {
            $year = (int) substr($stockData['date'], 0, 4) - 543;
            $stockData['date'] = $year . substr($stockData['date'], 4);
        }

        // ลบ "," ออกจาก trade_amount และ trading_value
        $stockData['trading_value'] = str_replace(',', '', $stockData['trading_value']);
        $stockData['trade_amount'] = str_replace(',', '', $stockData['trade_amount']);

        // กำหนดค่า change และ changepercent ให้เป็น 0 ถ้าไม่มีค่า
        $stockData['change'] = $stockData['change'] !== '' ? $stockData['change'] : 0;
        $stockData['changepercent'] = $stockData['changepercent'] !== '' ? $stockData['changepercent'] : 0;

        // ตรวจสอบข้อมูลก่อนบันทึก
        $validator = Validator::make($stockData, [
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

        if ($validator->fails()) {
            continue;
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        StockPriceP1::create([
            'date' => $stockData['date'],
            'open_price' => $stockData['open_price'],
            'high_price' => $stockData['high_price'],
            'low_price' => $stockData['low_price'],
            'previous_close_price' => $stockData['previous_close_price'],
            'change' => $stockData['change'],
            'changepercent' => $stockData['changepercent'],
            'trading_value' => $stockData['trading_value'],
            'trade_amount' => $stockData['trade_amount'] ?? null,
        ]);

        $imported++;
    }

    return response()->json([
        'status' => 201,
        'message' => "นำเข้าข้อมูลจาก CSV สำเร็จ ($imported รายการ)",
    ]);
}


}
