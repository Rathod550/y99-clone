<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Open chat
    public function index($id)
    {
        $user = User::findOrFail($id);

        $messages = Message::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)
              ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        return view('chat', compact('user', 'messages'));
    }

    // Send message
    public function send(Request $request, $id)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message));

        return response()->json(['status' => 'sent']);
    }
}
