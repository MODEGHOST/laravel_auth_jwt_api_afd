<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(News::all());
    }

    // เพิ่มข้อมูลพร้อมอัปโหลดไฟล์ PDF
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'date' => 'required|date',
        'pdf_file' => 'required|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
        'pdf_file_en' => 'required|file|mimes:pdf|max:20480',
    ]);

    // อัปโหลดไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $pdfFile = $request->file('pdf_file');
    $pdfFilename = $pdfFile->hashName(); // ใช้ hashName เพื่อสร้างชื่อไฟล์ที่ไม่ซ้ำ
    $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public');
 // อัปโหลดไฟล์ไปยังโฟลเดอร์ uploads/pdf_files
 $pdfFile = $request->file('pdf_file_en');
 $pdfFilenameEn = $pdfFile->hashName(); // ใช้ hashName เพื่อสร้างชื่อไฟล์ที่ไม่ซ้ำ
 $pdfFile->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public');

    // บันทึกข้อมูลลงในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $news = News::create([
        'title' => $request->input('title'),
        'title_en' => $request->input('title_en'),
        'date' => $request->input('date'),
        'pdf_url' => $pdfFilename, // เก็บเฉพาะชื่อไฟล์
        'pdf_url_en' => $pdfFilenameEn,
    ]);

    return response()->json(['message' => 'Created successfully', 'data' => $news]);
}

    

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
    
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'title_en' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'pdf_file' => 'sometimes|file|mimes:pdf|max:20480', // ตรวจสอบว่าเป็นไฟล์ PDF
            'pdf_file_en' => 'sometimes|file|mimes:pdf|max:20480',
        ]);
    
        // อัปโหลดไฟล์ PDF ภาษาไทยใหม่ (ถ้ามี)
        if ($request->hasFile('pdf_file')) {
            if ($news->pdf_url) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $news->pdf_url);
            }
            $pdfFilename = $request->file('pdf_file')->hashName();
            $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public');
            $news->pdf_url = $pdfFilename;
        }
    
        // อัปโหลดไฟล์ PDF ภาษาอังกฤษใหม่ (ถ้ามี)
        if ($request->hasFile('pdf_file_en')) {
            if ($news->pdf_url_en) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $news->pdf_url_en);
            }
            $pdfFilenameEn = $request->file('pdf_file_en')->hashName();
            $request->file('pdf_file_en')->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public');
            $news->pdf_url_en = $pdfFilenameEn;
        }
    
        // อัปเดตข้อมูลอื่น ๆ
        if ($request->title) {
            $news->title = $request->title;
        }
        if ($request->title_en) {
            $news->title_en = $request->title_en;
        }
        if ($request->date) {
            $news->date = $request->date;
        }
    
        $news->save();
    
        return response()->json(['message' => 'Updated successfully', 'data' => $news]);
    }
    


    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($news->pdf_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $news->pdf_url));
        }

        if ($news->pdf_url_en) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $news->pdf_url_en));
        }
        // ลบข้อมูลในฐานข้อมูล
        $news->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
