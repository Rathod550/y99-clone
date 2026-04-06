<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\FriendRequest;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = auth()->id();

        // all users except self
        $users = User::where('id', '!=', $currentUser)->get();

        // all friend requests (sent + received)
        $requests = FriendRequest::where(function ($q) use ($currentUser) {
            $q->where('sender_id', $currentUser)
              ->orWhere('receiver_id', $currentUser);
        })->get();

        // all friends
        $friends = DB::table('friends')->get();

        return view('users.index', compact('users', 'friends', 'requests'));
    }
}