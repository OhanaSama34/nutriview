<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    // Menampilkan halaman chat
    public function index()
    {
        $doctor = User::where('role', 'dokter')->first();

        if (!$doctor) {
            return back()->route('dashboard')->with('Tidak ada dokter tersedia.');
        }

        return view('chat.index', ['doctor' => $doctor]);
    }

    // Mengambil pesan antara user login dan dokter (AJAX)
    public function fetchMessages(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id'
        ]);

        $messages = Message::where(function ($q) use ($request) {
            $q->where('from_user', auth()->id())
              ->where('to_user', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('from_user', $request->receiver_id)
              ->where('to_user', auth()->id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    // Mengirim pesan (AJAX)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'from_user' => auth()->id(),
            'to_user' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }
}
