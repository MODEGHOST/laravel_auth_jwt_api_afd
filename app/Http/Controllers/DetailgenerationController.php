<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detailgeneration;
use Illuminate\Support\Facades\Storage;

class DetailgenerationController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        $data = Detailgeneration::all();

        // เพิ่ม URL เต็มสำหรับ pdf_url
        $data->map(function ($item) {
            $item->pdf_url = $item->pdf_url ? asset('storage/' . $item->pdf_url) : null;
            return $item;
        });

        return response()->json($data, 200);
    }

    // เพิ่มข้อมูลใหม่
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'year' => 'required|string|max:4',
        'description' => 'required|string',
        'quater' => 'nullable|string|max:10',
        'pdf_url' => 'nullable|file|mimes:pdf|max:20480',
    ]);

    // จัดเก็บไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $pdfFilename = $request->file('pdf_url') ? $request->file('pdf_url')->hashName() : null;
    if ($pdfFilename) {
        $request->file('pdf_url')->storeAs('uploads/pdf_files', $pdfFilename, 'public');
    }

    // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $detail = Detailgeneration::create([
        'title' => $request->title,
        'year' => $request->year,
        'description' => $request->description,
        'quater' => $request->quater,
        'pdf_url' => $pdfFilename, // เก็บเฉพาะชื่อไฟล์
    ]);

    return response()->json($detail, 201);
}


    // อัปเดตข้อมูล
    public function update(Request $request, $id)
{
    $detail = Detailgeneration::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'year' => 'required|string|max:4',
        'description' => 'required|string',
        'quater' => 'nullable|string|max:10',
        'pdf_url' => 'nullable|file|mimes:pdf|max:20480',
    ]);

    if ($request->hasFile('pdf_url')) {
        // ลบไฟล์เก่าถ้ามี
        if ($detail->pdf_url) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $detail->pdf_url); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
        }

        // อัปโหลดไฟล์ใหม่และเก็บเฉพาะชื่อไฟล์
        $pdfFilename = $request->file('pdf_url')->hashName(); // สร้างชื่อไฟล์ใหม่
        $request->file('pdf_url')->storeAs('uploads/pdf_files/', $pdfFilename, 'public'); // อัปโหลดไฟล์ใหม่
        $detail->pdf_url = $pdfFilename; // เก็บเฉพาะชื่อไฟล์
    }

    // อัปเดตข้อมูลอื่นๆ
    $detail->update([
        'title' => $request->title,
        'year' => $request->year,
        'description' => $request->description,
        'quater' => $request->quater,
        'pdf_url' => $detail->pdf_url, // ใช้ชื่อไฟล์เดิมถ้าไม่มีการอัปโหลดใหม่
    ]);

    return response()->json($detail, 200);
}


    // ลบข้อมูล
    public function destroy($id)
    {
        $detail = Detailgeneration::findOrFail($id);

        // ลบไฟล์ PDF ถ้ามี
        if ($detail->pdf_url) {
            Storage::disk('public')->delete($detail->pdf_url);
        }

        $detail->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
