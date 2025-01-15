<?php

namespace App\Http\Controllers;

use App\Models\Newsmarket;
use Illuminate\Http\Request;

class NewsmarketController extends Controller
{
    // แสดงรายการข่าว
    public function index()
    {
        $news = Newsmarket::all(); // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
        return response()->json($news); // ส่งกลับในรูปแบบ JSON
    }
    // เพิ่มข่าวใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|string',
            'title' => 'required|string',
            'pdf_url' => 'required|string',
        ]);

        $news = Newsmarket::create($validated);
        return response()->json($news, 201);
    }

    // แก้ไขข่าว
    public function update(Request $request, $id)
    {
        $news = Newsmarket::findOrFail($id);
        $validated = $request->validate([
            'date' => 'required|string',
            'title' => 'required|string',
            'pdf_url' => 'required|string',
        ]);

        $news->update($validated);
        return response()->json($news);
    }
    // ลบข่าว
    public function destroy($id)
    {
        $news = Newsmarket::findOrFail($id);
        $news->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}