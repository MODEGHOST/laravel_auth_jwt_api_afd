<?php
namespace App\Http\Controllers;

use App\Models\Adminofgod;
use App\Models\Log;
use Illuminate\Http\Request;

class AdminofgodController extends Controller
{
    // เพิ่มข้อมูล Log
    protected function logAction($adminId, $action, $description, $ipAddress)
    {
        Log::create([
            'admin_id' => $adminId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
        ]);
    }

    // ตรวจจับกิจกรรมที่ไม่ได้รับอนุญาต
    protected function logUnauthorizedAccess($request)
    {
        $this->logAction(
            null, // ไม่มี admin_id เพราะไม่ใช่การกระทำของผู้ใช้ที่ล็อกอิน
            'hack',
            'Unauthorized access attempt detected',
            $request->ip()
        );
    }

    // เพิ่มข้อมูลผู้ดูแลระบบใหม่
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:Adminofgod,email',
                'password' => 'required|string|max:255',
                'role' => 'in:admin,superadmin',
            ]);

            $admin = Adminofgod::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role ?? 'admin',
            ]);

            $this->logAction(
                auth()->id(),
                'create',
                "Added admin: {$admin->name}",
                $request->ip()
            );

            return response()->json(['message' => 'Admin created successfully', 'data' => $admin], 201);
        } catch (\Exception $e) {
            $this->logUnauthorizedAccess($request);
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    }

    // อัปเดตข้อมูลผู้ดูแลระบบ
    public function update(Request $request, $id)
    {
        try {
            $admin = Adminofgod::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:Adminofgod,email,' . $admin->id,
                'password' => 'nullable|string|max:255',
                'role' => 'in:admin,superadmin',
            ]);

            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ?? $admin->password,
                'role' => $request->role ?? $admin->role,
            ]);

            $this->logAction(
                auth()->id(),
                'update',
                "Updated admin: {$admin->name}",
                $request->ip()
            );

            return response()->json(['message' => 'Admin updated successfully', 'data' => $admin], 200);
        } catch (\Exception $e) {
            $this->logUnauthorizedAccess($request);
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    }

    // ลบข้อมูลผู้ดูแลระบบ
    public function destroy($id, Request $request)
    {
        try {
            $admin = Adminofgod::findOrFail($id);

            $this->logAction(
                auth()->id(),
                'delete',
                "Deleted admin: {$admin->name}",
                $request->ip()
            );

            $admin->delete();

            return response()->json(['message' => 'Admin deleted successfully'], 200);
        } catch (\Exception $e) {
            $this->logUnauthorizedAccess($request);
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    }

    // ดึง Logs
    public function getLogs()
    {
        $logs = Log::with('admin')->orderBy('created_at', 'desc')->get();
        return response()->json($logs, 200);
    }
}
