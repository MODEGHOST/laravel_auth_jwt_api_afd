<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * ดึงข้อมูลกิจกรรมทั้งหมด
     */
    public function index()
    {
        $events = Event::all();

        return response()->json([
            'status' => 200,
            'data' => $events,
        ]);
    }

    /**
     * เพิ่มข้อมูลกิจกรรมใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event = Event::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'เพิ่มกิจกรรมสำเร็จ',
            'data' => $event,
        ]);
    }

    /**
     * ดึงข้อมูลกิจกรรมตาม ID
     */
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบกิจกรรม',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $event,
        ]);
    }

    /**
     * อัปเดตกิจกรรม
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบกิจกรรม',
            ]);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'อัปเดตกิจกรรมสำเร็จ',
            'data' => $event,
        ]);
    }

    /**
     * ลบกิจกรรม
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 404,
                'message' => 'ไม่พบกิจกรรม',
            ]);
        }

        $event->delete();

        return response()->json([
            'status' => 200,
            'message' => 'ลบกิจกรรมสำเร็จ',
        ]);
    }
}
