<?php

namespace App\Http\Controllers;

use App\Models\Newsprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsprintController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Newsprint::all());
    }

    // เพิ่มข้อมูลพร้อมอัปโหลดไฟล์ PDF
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'pdf_file' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
    ]);

    // อัปโหลดไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $pdfFile = $request->file('pdf_file');
    $pdfFilename = $pdfFile->hashName(); // ใช้ hashName เพื่อสร้างชื่อไฟล์ที่ไม่ซ้ำ
    $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ไปยังโฟลเดอร์ newsprint

    // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $newsprint = Newsprint::create([
        'title' => $request->input('title'),
        'date' => $request->input('date'),
        'pdf_url' => $pdfFilename, // เก็บเฉพาะชื่อไฟล์
    ]);

    return response()->json(['message' => 'Created successfully', 'data' => $newsprint]);
}


    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
{
    $newsprint = Newsprint::findOrFail($id);

    $request->validate([
        'title' => 'sometimes|string|max:255',
        'date' => 'sometimes|date',
        'pdf_file' => 'sometimes|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
    ]);

    // หากมีการอัปโหลดไฟล์ PDF ใหม่
    if ($request->hasFile('pdf_file')) {
        // ลบไฟล์ PDF เดิม
        if ($newsprint->pdf_url) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $newsprint->pdf_url); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
        }

        // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
        $pdfFilename = $request->file('pdf_file')->hashName(); // สร้างชื่อไฟล์ใหม่
        $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ใหม่
        $newsprint->pdf_url = $pdfFilename; // เก็บเฉพาะชื่อไฟล์
    }

    // อัปเดตข้อมูลอื่นๆ
    if ($request->title) {
        $newsprint->title = $request->title;
    }
    if ($request->date) {
        $newsprint->date = $request->date;
    }

    $newsprint->save();

    return response()->json(['message' => 'Updated successfully', 'data' => $newsprint]);
}


    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $newsprint = Newsprint::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($newsprint->pdf_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $newsprint->pdf_url));
        }

        // ลบข้อมูลในฐานข้อมูล
        $newsprint->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
