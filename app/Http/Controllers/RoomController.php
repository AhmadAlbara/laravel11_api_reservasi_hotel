<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:available,booked',
        ]);

        $room = Room::create($request->all());
        return response()->json($room, 201);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return response()->json($room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(null, 204);
    }
}
