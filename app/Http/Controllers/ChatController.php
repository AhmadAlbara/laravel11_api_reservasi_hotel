<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $hotelId = $request->query('hotel_id');

        $query = Chat::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($hotelId) {
            $query->where('hotel_id', $hotelId);
        }

        $chats = $query->with(['user', 'hotel'])->get();

        return response()->json([
            'success' => true,
            'data' => $chats,
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Chat berhasil dibuat.',
            'data' => $chat,
        ], 201);
    }

    
    public function show($id)
    {
        $chat = Chat::with(['user', 'hotel'])->find($id);

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $chat,
        ]);
    }

 
    public function update(Request $request, $id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat tidak ditemukan.',
            ], 404);
        }

        $validatedData = $request->validate([
            'message' => 'required|string',
        ]);

        $chat->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Chat berhasil diperbarui.',
            'data' => $chat,
        ]);
    }

 
    public function destroy($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Chat tidak ditemukan.',
            ], 404);
        }

        $chat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat berhasil dihapus.',
        ]);
    }
}
