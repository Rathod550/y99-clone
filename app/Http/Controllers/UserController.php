<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;

class UserController extends Controller
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
}