<?php

namespace App\Http\Controllers;

use App\Models\Policypayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PolicypaymentController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Policypayment::all());
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
        $pdfFilename = $pdfFile->hashName();
        $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public');

        // บันทึกข้อมูลลงในฐานข้อมูล
        $policypayment = Policypayment::create([
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'pdf_url' => $pdfFilename,
        ]);

        return response()->json(['message' => 'Created successfully', 'data' => $policypayment]);
    }

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
    {
        $policypayment = Policypayment::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'pdf_file' => 'sometimes|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        ]);

        // หากมีการอัปโหลดไฟล์ PDF ใหม่
        if ($request->hasFile('pdf_file')) {
            // ลบไฟล์ PDF เดิม
            if ($policypayment->pdf_url) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $policypayment->pdf_url);
            }

            // อัปโหลดไฟล์ PDF ใหม่
            $pdfFilename = $request->file('pdf_file')->hashName();
            $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public');
            $policypayment->pdf_url = $pdfFilename;
        }

        // อัปเดตข้อมูลอื่นๆ
        if ($request->title) {
            $policypayment->title = $request->title;
        }
        if ($request->date) {
            $policypayment->date = $request->date;
        }

        $policypayment->save();

        return response()->json(['message' => 'Updated successfully', 'data' => $policypayment]);
    }

    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $policypayment = Policypayment::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($policypayment->pdf_url) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $policypayment->pdf_url);
        }

        // ลบข้อมูลในฐานข้อมูล
        $policypayment->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
