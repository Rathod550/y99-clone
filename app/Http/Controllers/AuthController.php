<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function guestLogin()
    {
        $random = rand(1000, 9999);

        $user = User::create([
            'name' => 'Guest_' . $random,
            'username' => 'guest_' . $random,
            'email' => 'guest_' . $random . '@mail.com',
            'password' => bcrypt('password'),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}