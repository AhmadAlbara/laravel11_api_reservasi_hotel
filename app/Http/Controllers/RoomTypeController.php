<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return response()->json($roomTypes);
    }

    public function show($id)
    {
        $roomType = RoomType::findOrFail($id);
        return response()->json($roomType);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1',
        ]);

        $roomType = RoomType::create($request->all());
        return response()->json($roomType, 201);
    }

    public function update(Request $request, $id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->update($request->all());
        return response()->json($roomType);
    }

    public function destroy($id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->delete();
        return response()->json(null, 204);
    }
}
