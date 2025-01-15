<?php

namespace App\Http\Controllers;

use App\Models\Adminofgod;
use Illuminate\Http\Request;

class AdminofgodController extends Controller
{
    // ดึงข้อมูลผู้ดูแลระบบทั้งหมด
    public function index()
    {
        $admins = adminofgod::all();
        return response()->json($admins, 200);
    }

    // เพิ่มข้อมูลผู้ดูแลระบบใหม่
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:adminofgod,email',
            'password' => 'required|string|max:255',
            'role' => 'in:admin,superadmin',
        ]);

        $admin = adminofgod::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // บันทึกโดยไม่เข้ารหัส
            'role' => $request->role ?? 'admin',
        ]);

        return response()->json(['message' => 'Admin created successfully', 'data' => $admin], 201);
    }

    // อัปเดตข้อมูลผู้ดูแลระบบ
    public function update(Request $request, $id)
    {
        $admin = adminofgod::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:adminofgod,email,' . $admin->id,
            'password' => 'nullable|string|max:255',
            'role' => 'in:admin,superadmin',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? $admin->password, // เก็บค่ารหัสผ่านเดิมถ้าไม่ได้เปลี่ยน
            'role' => $request->role ?? $admin->role,
        ]);

        return response()->json(['message' => 'Admin updated successfully', 'data' => $admin], 200);
    }

    // ลบข้อมูลผู้ดูแลระบบ
    public function destroy($id)
    {
        $admin = adminofgod::findOrFail($id);
        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }

    // ดึงข้อมูลผู้ดูแลระบบตาม ID
    public function show($id)
    {
        $admin = adminofgod::findOrFail($id);
        return response()->json($admin, 200);
    }


    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $admin = adminofgod::where('email', $request->email)->first();

    if (!$admin || $admin->password !== $request->password) {
        return response()->json(['error' => 'Invalid email or password'], 401);
    }

    // Return user details and a token (placeholder for token)
    return response()->json([
        'message' => 'Login successful',
        'user' => [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => $admin->role,
        ],
        'access_token' => base64_encode($admin->email . ':' . $admin->password), // Placeholder token
    ], 200);
}

}
