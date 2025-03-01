<?php

namespace App\Http\Controllers;

use App\Models\Reportmtuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportmtuserController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Reportmtuser::all());
    }

    // เพิ่มข้อมูลพร้อมอัปโหลดไฟล์ PDF
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'pdf_file' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        'pdf_file_en' => 'required|file|mimes:pdf|max:20480',
    ]);

    // จัดเก็บไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $pdfFile = $request->file('pdf_file');
    $pdfFilename = $pdfFile->hashName(); // สร้างชื่อไฟล์ที่ไม่ซ้ำ
    $pdfFile->storeAs('uploads/pdf_files/', $pdfFilename, 'public'); // อัปโหลดไฟล์ไปยังโฟลเดอร์ reportmtuser

    $pdfFile = $request->file('pdf_file_en');
    $pdfFilenameEn = $pdfFile->hashName(); // สร้างชื่อไฟล์ที่ไม่ซ้ำ
    $pdfFile->storeAs('uploads/pdf_files/', $pdfFilename, 'public');

    // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $reportmtuser = Reportmtuser::create([
        'title' => $request->input('title'),
        'title_en' => $request->input('title_en'),
        'pdf_file' => $pdfFilename, // เก็บเฉพาะชื่อไฟล์
        'pdf_file_en'=>$pdfFilenameEn
    ]);

    return response()->json(['message' => 'Created successfully', 'data' => $reportmtuser]);
}

    

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
{
    $reportmtuser = Reportmtuser::findOrFail($id);

    $request->validate([
        'title' => 'sometimes|string|max:255',
        'title_en' => 'sometimes|string|max:255',
        'date' => 'sometimes|date',
        'pdf_file' => 'sometimes|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        'pdf_file_en' => 'sometimes|file|mimes:pdf|max:20480',
    ]);

    // หากมีการอัปโหลดไฟล์ PDF ใหม่
    if ($request->hasFile('pdf_file')) {
        // ลบไฟล์ PDF เดิม
        if ($reportmtuser->pdf_file) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $reportmtuser->pdf_file); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
        }

        // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
        $pdfFilename = $request->file('pdf_file')->hashName(); // สร้างชื่อไฟล์ใหม่
        $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ใหม่
        $reportmtuser->pdf_file = $pdfFilename; // เก็บเฉพาะชื่อไฟล์


        if ($reportmtuser->pdf_file_en) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $reportmtuser->pdf_file); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
        }

        // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
        $pdfFilenameEn = $request->file('pdf_file_en')->hashName(); // สร้างชื่อไฟล์ใหม่
        $request->file('pdf_file_en')->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public'); // อัปโหลดไฟล์ใหม่
        $reportmtuser->pdf_file = $pdfFilenameEn; // เก็บเฉพาะชื่อไฟล์
    }

    // อัปเดตข้อมูลอื่นๆ
    if ($request->has('title')) {
        $reportmtuser->title = $request->title;
    }
    if ($request->has('title_en')) {
        $reportmtuser->title_en = $request->title_en;
    }
    if ($request->has('date')) {
        $reportmtuser->date = $request->date;
    }

    $reportmtuser->save();

    return response()->json(['message' => 'Updated successfully', 'data' => $reportmtuser]);
}


    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $reportmtuser = Reportmtuser::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($reportmtuser->pdf_file) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $reportmtuser->pdf_file));
        }

        if ($reportmtuser->pdf_file_en) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $reportmtuser->pdf_file_en));
        }
        // ลบข้อมูลในฐานข้อมูล
        $reportmtuser->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
