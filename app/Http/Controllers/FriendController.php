<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // Send Request
    public function send($id)
    {
        // Prevent self request
        if (auth()->id() == $id) {
            return back();
        }

        // Check existing request (both directions)
        $exists = \App\Models\FriendRequest::where(function ($q) use ($id) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('sender_id', $id)
              ->where('receiver_id', auth()->id());
        })->first();

        if ($exists) {
            return back(); // already exists
        }

        \App\Models\FriendRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
        ]);

        return back();
    }

    // Accept Request
    public function accept($id)
    {
        $request = FriendRequest::findOrFail($id);
        $request->update(['status' => 'accepted']);

        return back();
    }

    // Reject Request
    public function reject($id)
    {
        $request = FriendRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return back();
    }
}