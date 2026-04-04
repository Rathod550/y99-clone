<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $requests = FriendRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        // Accepted friends
        $friends = FriendRequest::where(function ($q) {
                $q->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
            })
            ->where('status', 'accepted')
            ->get();

        return view('dashboard', compact('users', 'requests', 'friends'));
    }
}
