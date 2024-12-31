<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with(['operator', 'roomTypes', 'rooms', 'photos', 'facilities', 'chats'])->get();
        return response()->json($hotels);
    }

    public function show($id)
    {
        $hotel = Hotel::with(['operator', 'roomTypes', 'rooms', 'photos', 'facilities', 'chats'])->findOrFail($id);
        return response()->json($hotel);
    }

    public function store(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'description'=>'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $hotel = Hotel::create($request->all());
        return response()->json($hotel, 201);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return response()->json($hotel);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(null, 204);
    }
}
