<?php

namespace App\Http\Controllers;

use App\Models\HolderStuc;
use Illuminate\Http\Request;

class HolderStucController extends Controller
{
    // ดึงข้อมูลผู้ถือหุ้นทั้งหมด
    public function index()
    {
        $holders = HolderStuc::all();
        return response()->json($holders, 200);
    }

    // เพิ่มผู้ถือหุ้นใหม่
    public function store(Request $request)
    {
        $request->validate([
            'holder_name' => 'required|string|max:255',
            'shares_count' => 'required|integer',
            'share_percentage' => 'required|numeric',
        ]);

        $holder = HolderStuc::create($request->all());
        return response()->json($holder, 201);
    }

    // แก้ไขข้อมูลผู้ถือหุ้น
    public function update(Request $request, $id)
    {
        $holder = HolderStuc::findOrFail($id);

        $request->validate([
            'holder_name' => 'required|string|max:255',
            'shares_count' => 'required|integer',
            'share_percentage' => 'required|numeric',
        ]);

        $holder->update($request->all());
        return response()->json($holder, 200);
    }

    // ลบข้อมูลผู้ถือหุ้น
    public function destroy($id)
    {
        $holder = HolderStuc::findOrFail($id);
        $holder->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
