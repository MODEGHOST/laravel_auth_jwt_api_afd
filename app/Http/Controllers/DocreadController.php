<?php
namespace App\Http\Controllers;

use App\Models\Docread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder as QrCodeBuilder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class DocreadController extends Controller
{
    public function index()
    {
        $reports = Docread::all();
        return response()->json($reports);
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf|max:20480',
        'date' => 'required|date', // เพิ่มการ validate ฟิลด์ date
    ]);

    // อัปโหลดไฟล์ PDF และเก็บเฉพาะชื่อไฟล์
    $file = $request->file('file');
    $fileName = $file->hashName(); // สร้างชื่อไฟล์แบบไม่ซ้ำ
    $file->storeAs('uploads/pdf_files', $fileName, 'public');

    // สร้าง QR Code ด้วย URL ที่สมบูรณ์
    $qrCodeFileName = uniqid() . '.png'; // สร้างชื่อไฟล์ QR Code แบบไม่ซ้ำ
    $qrCodeContent = 'http://129.200.6.52/laravel_auth_jwt_api_omd/storage/app/public/uploads/pdf_files/' . $fileName;


    $qrCode = QrCodeBuilder::create()
        ->data($qrCodeContent)
        ->encoding(new Encoding('UTF-8'))
        ->size(200)
        ->writer(new PngWriter())
        ->build();

    // บันทึก QR Code ลงใน Storage และเก็บเฉพาะชื่อไฟล์
    Storage::disk('public')->put('uploads/images/' . $qrCodeFileName, $qrCode->getString());

    // บันทึกข้อมูลในฐานข้อมูล โดยเก็บเฉพาะชื่อไฟล์
    $docread = Docread::create([
        'title' => $request->title,
        'file_path' => $fileName, // เก็บเฉพาะชื่อไฟล์ PDF
        'qr_code_path' => $qrCodeFileName, // เก็บเฉพาะชื่อไฟล์ QR Code
        'date' => $request->date, // เพิ่มการบันทึกฟิลด์ date
    ]);

    return response()->json(['message' => 'Uploaded successfully!', 'data' => $docread], 201);
}


public function update(Request $request, $id)
{
    $docread = Docread::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'file' => 'file|mimes:pdf|max:20480',
        'date' => 'required|date', // เพิ่มการ validate ฟิลด์ date
    ]);

    if ($request->hasFile('file')) {
        // ลบไฟล์ PDF และ QR Code เดิม
        if ($docread->file_path) {
            Storage::disk('public')->delete('uploads/pdf_files/' . $docread->file_path);
        }
        if ($docread->qr_code_path) {
            Storage::disk('public')->delete('uploads/images/' . $docread->qr_code_path);
        }

        // อัปโหลดไฟล์ PDF ใหม่ และเก็บเฉพาะชื่อไฟล์
        $fileFilename = $request->file('file')->hashName();
        $request->file('file')->storeAs('uploads/pdf_files', $fileFilename, 'public');
        $docread->file_path = $fileFilename;

        // สร้าง QR Code ใหม่
        $qrCodeFilename = uniqid() . '.png';
        $qrCodeContent = url('storage/uploads/pdf_files/' . $fileFilename);

        $qrCode = QrCodeBuilder::create()
            ->data($qrCodeContent)
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->writer(new PngWriter())
            ->build();

        // บันทึก QR Code ใหม่ และเก็บเฉพาะชื่อไฟล์
        Storage::disk('public')->put('uploads/images/' . $qrCodeFilename, $qrCode->getString());
        $docread->qr_code_path = $qrCodeFilename;
    }

    $docread->title = $request->title;
    $docread->date = $request->date; // เพิ่มการบันทึกฟิลด์ date
    $docread->save();

    return response()->json(['message' => 'Updated successfully!', 'data' => $docread]);
}


    public function destroy($id)
    {
        $docread = Docread::findOrFail($id);

        Storage::disk('public')->delete([$docread->file_path, $docread->qr_code_path]);

        $docread->delete();

        return response()->json(['message' => 'Deleted successfully!']);
    }

    public function show($id)
    {
        $docread = Docread::findOrFail($id);
        return response()->json($docread);
    }
}
