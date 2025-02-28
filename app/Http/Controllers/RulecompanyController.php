<?php

namespace App\Http\Controllers;

use App\Models\Rulecompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RulecompanyController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Rulecompany::all());
    }

    // เพิ่มข้อมูลพร้อมอัปโหลดไฟล์ PDF
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'date' => 'required|date',
            'pdf_file' => 'required|file|mimes:pdf|max:20480',
            'pdf_file_en' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        ]);

       // อัปโหลดไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
        $pdfFile = $request->file('pdf_file');
        $pdfFilename = $pdfFile->hashName(); // ใช้ hashName เพื่อสร้างชื่อไฟล์ที่ไม่ซ้ำ
        $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public');

        $pdfFile = $request->file('pdf_file_en');
        $pdfFilenameEn = $pdfFile->hashName(); // ใช้ hashName เพื่อสร้างชื่อไฟล์ที่ไม่ซ้ำ
        $pdfFile->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public');


        // บันทึกข้อมูลลงในฐานข้อมูล
        $rulecompany = Rulecompany::create([
            'title' => $request->input('title'),
            'title_en' => $request->input('title_en'),
            'date' => $request->input('date'),
            'pdf_url' => $pdfFilename, // เก็บ URL ของไฟล์ PDF
            'pdf_url_en'=>$pdfFilenameEn
        ]);

        return response()->json(['message' => 'Created successfully', 'data' => $rulecompany]);
    }

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
    {
        $rulecompany = Rulecompany::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'date' => 'required|date',
            'pdf_file' => 'required|file|mimes:pdf|max:20480',
            'pdf_file_en' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        ]);

        // หากมีการอัปโหลดไฟล์ PDF ใหม่
        if ($request->hasFile('pdf_file')) {
            // ลบไฟล์ PDF เดิม
            if ($rulecompany->pdf_file) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $rulecompany->pdf_file); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
            }
    
            // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
            $pdfFilename = $request->file('pdf_file')->hashName(); // สร้างชื่อไฟล์ใหม่
            $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public'); // อัปโหลดไฟล์ใหม่
            $rulecompany->pdf_file = $pdfFilename; // เก็บเฉพาะชื่อไฟล์


            if ($rulecompany->pdf_file_en) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $rulecompany->pdf_file); // ลบไฟล์เดิมโดยใช้ชื่อไฟล์
            }
    
            // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
            $pdfFilenameEn = $request->file('pdf_file_en')->hashName(); // สร้างชื่อไฟล์ใหม่
            $request->file('pdf_file_en')->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public'); // อัปโหลดไฟล์ใหม่
            $rulecompany->pdf_file = $pdfFilenameEn; // เก็บเฉพาะชื่อไฟล์
        }

        // อัปเดตข้อมูลอื่นๆ
        if ($request->title) {
            $rulecompany->title = $request->title;
        }
        if ($request->title_en) {
            $rulecompany->title = $request->title;
        }
        if ($request->date) {
            $rulecompany->date = $request->date;
        }

        $rulecompany->save();

        return response()->json(['message' => 'Updated successfully', 'data' => $rulecompany]);
    }

    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $rulecompany = Rulecompany::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($rulecompany->pdf_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $rulecompany->pdf_url));
        }

        if ($rulecompany->pdf_url_en) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $rulecompany->pdf_url_en));
        }

        // ลบข้อมูลในฐานข้อมูล
        $rulecompany->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
