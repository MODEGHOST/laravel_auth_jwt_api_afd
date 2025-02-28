<?php

namespace App\Http\Controllers;

use App\Models\Proposeagenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposeagendaController extends Controller
{
    // ดึงข้อมูลทั้งหมด
    public function index()
    {
        return response()->json(Proposeagenda::all());
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
        $pdfFilename = $pdfFile->hashName();
        $pdfFile->storeAs('uploads/pdf_files', $pdfFilename, 'public');

        $pdfFile = $request->file('pdf_file_en');
        $pdfFilenameEn = $pdfFile->hashName();
        $pdfFile->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public');

        // บันทึกข้อมูลลงในฐานข้อมูล
        $proposeagenda = Proposeagenda::create([
            'title' => $request->input('title'),
            'title_en' => $request->input('title_en'),
            'date' => $request->input('date'),
            'pdf_url' => $pdfFilename,
            'pdf_url_en' => $pdfFilenameEn
        ]);

        return response()->json(['message' => 'Created successfully', 'data' => $proposeagenda]);
    }

    // แก้ไขข้อมูลพร้อมอัปโหลดไฟล์ใหม่
    public function update(Request $request, $id)
    {
        $proposeagenda = Proposeagenda::findOrFail($id);

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
            if ($proposeagenda->pdf_url) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $proposeagenda->pdf_url);
            }

            // อัปโหลดไฟล์ PDF ใหม่
            $pdfFilename = $request->file('pdf_file')->hashName();
            $request->file('pdf_file')->storeAs('uploads/pdf_files', $pdfFilename, 'public');
            $proposeagenda->pdf_url = $pdfFilename;

            if ($proposeagenda->pdf_url_en) {
                Storage::disk('public')->delete('uploads/pdf_files/' . $proposeagenda->pdf_url_en);
            }

            // อัปโหลดไฟล์ PDF ใหม่
            $pdfFilenameEn = $request->file('pdf_file_en')->hashName();
            $request->file('pdf_file_en')->storeAs('uploads/pdf_files', $pdfFilenameEn, 'public');
            $proposeagenda->pdf_url = $pdfFilenameEn;
        }

        // อัปเดตข้อมูลอื่นๆ
        if ($request->title) {
            $proposeagenda->title = $request->title;
        }
        if ($request->title_en) {
            $proposeagenda->title_en = $request->title_en;
        }
        if ($request->date) {
            $proposeagenda->date = $request->date;
        }

        $proposeagenda->save();

        return response()->json(['message' => 'Updated successfully', 'data' => $proposeagenda]);
    }

    // ลบข้อมูลพร้อมลบไฟล์ PDF
    public function destroy($id)
    {
        $proposeagenda = Proposeagenda::findOrFail($id);

        // ลบไฟล์ PDF จาก Storage
        if ($proposeagenda->pdf_url) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $proposeagenda->pdf_url);
        }
        if ($proposeagenda->pdf_url_en) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $proposeagenda->pdf_url_en);
        }

        // ลบข้อมูลในฐานข้อมูล
        $proposeagenda->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
