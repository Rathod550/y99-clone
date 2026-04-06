<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Guest Login (Anonymous)
|--------------------------------------------------------------------------
*/
Route::get('/guest-login', [AuthController::class, 'guestLogin'])->name('guest.login');

/*
|--------------------------------------------------------------------------
| Dashboard (Protected)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // friends
    Route::get('/friends/send/{id}', [FriendController::class, 'send']);
    Route::get('/friends/accept/{id}', [FriendController::class, 'accept']);
    Route::get('/friends/reject/{id}', [FriendController::class, 'reject']);

    // chat
    Route::get('/chat/{id}', [ChatController::class, 'index']);
    Route::post('/chat/{id}', [ChatController::class, 'send']);

    // rooms
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/room/{slug}', [RoomController::class, 'show']);
    Route::post('/room/{id}/send', [RoomController::class, 'send']);
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/room/{slug}', [RoomController::class, 'show']);
    Route::post('/rooms/create', [RoomController::class, 'store']);
});


/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';