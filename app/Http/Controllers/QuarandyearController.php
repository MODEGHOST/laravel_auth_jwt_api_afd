<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quarandyear;

class QuarandyearController extends Controller
{
    /**
     * ดึงข้อมูลทั้งหมด
     */
    public function index()
    {
        $data = Quarandyear::all();

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
        $data = Quarandyear::find($id);

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
            'Qpercent' => 'required|numeric',
            'Ypercent' => 'required|numeric',
        ]);

        $data = Quarandyear::create($validated);

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
        $data = Quarandyear::find($id);

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }

        $validated = $request->validate([
            'Qpercent' => 'required|numeric',
            'Ypercent' => 'required|numeric',
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
        $data = Quarandyear::find($id);

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
