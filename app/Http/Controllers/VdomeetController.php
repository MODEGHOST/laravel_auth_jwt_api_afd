<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vdomeet;

class VdomeetController extends Controller
{
    public function index()
    {
        $videos = Vdomeet::all();
        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|url|max:255',
            'published_date' => 'required|date',
        ]);

        $video = Vdomeet::create([
            'title' => $request->title,
            'youtube_link' => $request->youtube_link,
            'published_date' => $request->published_date
        ]);

        return response()->json(['message' => 'Video saved successfully', 'data' => $video], 201);
    }

    public function show($id)
    {
        $video = Vdomeet::findOrFail($id);
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'youtube_link' => 'sometimes|required|url|max:255',
            'published_date' => 'sometimes|required|date',
        ]);

        $video = Vdomeet::findOrFail($id);
        $video->update($request->all());

        return response()->json(['message' => 'Video updated successfully', 'data' => $video]);
    }

    public function destroy($id)
    {
        $video = Vdomeet::findOrFail($id);
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
