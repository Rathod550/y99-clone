<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;

class FriendRequestController extends Controller
{
    public function index()
    {
        $requests = FriendRequest::with('sender')
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('friends.requests', compact('requests'));
    }

    // ✅ ADD THIS METHOD
    public function send($id)
    {
        $exists = FriendRequest::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)
              ->where('receiver_id', auth()->id());
        })->exists();

        if (!$exists) {
            FriendRequest::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $id,
                'status' => 'pending'
            ]);
        }

        return back();
    }

    public function accept($id)
    {
        $req = FriendRequest::findOrFail($id);
        $req->update(['status' => 'accepted']);

        return back();
    }

    public function reject($id)
    {
        $req = FriendRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back();
    }
}
