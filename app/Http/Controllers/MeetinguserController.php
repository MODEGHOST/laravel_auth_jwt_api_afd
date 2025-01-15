<?php

namespace App\Http\Controllers;

use App\Models\Meetinguser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeetinguserController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Meetinguser::all());
    }

    // เพิ่มข้อมูลพร้อมอัปโหลดไฟล์ PDF
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'pdf_file' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
    ]);

    // จัดเก็บไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $pdfFile = $request->file('pdf_file');
    $pdfFilename = $pdfFile->hashName(); // สร้างชื่อไฟล์ที่ไม่ซ้ำ
    $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ไปยังโฟลเดอร์ meetinguser

    // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $meetinguser = Meetinguser::create([
        'title' => $request->input('title'),
        'pdf_file' => $pdfFilename, // เก็บเฉพาะชื่อไฟล์
    ]);

    return response()->json(['message' => 'Created successfully', 'data' => $meetinguser]);
}

    

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
{
    $meetinguser = Meetinguser::findOrFail($id);

    $request->validate([
        'title' => 'sometimes|string|max:255',
        'date' => 'sometimes|date',
        'pdf_file' => 'sometimes|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
    ]);

    // หากมีการอัปโหลดไฟล์ PDF ใหม่
    if ($request->hasFile('pdf_file')) {
        // ลบไฟล์ PDF เดิม
        if ($meetinguser->pdf_file) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $meetinguser->pdf_file); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
        }

        // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
        $pdfFilename = $request->file('pdf_file')->hashName(); // สร้างชื่อไฟล์ใหม่
        $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ใหม่
        $meetinguser->pdf_file = $pdfFilename; // เก็บเฉพาะชื่อไฟล์
    }

    // อัปเดตข้อมูลอื่นๆ
    if ($request->has('title')) {
        $meetinguser->title = $request->title;
    }
    if ($request->has('date')) {
        $meetinguser->date = $request->date;
    }

    $meetinguser->save();

    return response()->json(['message' => 'Updated successfully', 'data' => $meetinguser]);
}


    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $meetinguser = Meetinguser::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($meetinguser->pdf_file) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $meetinguser->pdf_file));
        }

        // ลบข้อมูลในฐานข้อมูล
        $meetinguser->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
