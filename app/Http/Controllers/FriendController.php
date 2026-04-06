<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $friends = Friend::where(function ($q) {
            $q->where('sender_id', auth()->id())
              ->orWhere('receiver_id', auth()->id());
        })->get();

        return view('users.index', compact('users', 'friends'));
    }
    
    // SEND REQUEST
    public function send($id)
    {
        Friend::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'status' => 'pending'
        ]);

        return back();
    }

    // ACCEPT
    public function accept($id)
    {
        $friend = Friend::findOrFail($id);
        $friend->update(['status' => 'accepted']);

        return back();
    }

    // REJECT
    public function reject($id)
    {
        Friend::where('id', $id)->delete();

        return back();
    }
}