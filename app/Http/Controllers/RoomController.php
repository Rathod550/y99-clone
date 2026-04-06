<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomMessage;
use App\Events\RoomMessageSent;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function show($slug)
    {
        $room = Room::where('slug', $slug)->firstOrFail();

        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            return redirect('/rooms')->with('error', 'Join room first');
        }

        $messages = RoomMessage::with('user')
            ->where('room_id', $room->id)
            ->latest()
            ->take(50)
            ->get()
            ->reverse();

        return view('rooms.chat', compact('room', 'messages'));
    }

    public function send(Request $request, $roomId)
    {

        $room = Room::findOrFail($roomId);
        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            return response()->json(['error' => 'Join room first'], 403);
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        $message = RoomMessage::create([
            'room_id' => $roomId,
            'user_id' => auth()->id() ?? 1,
            'message' => $request->message
        ]);

        broadcast(new RoomMessageSent($message));

        return response()->json(['status' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $slug = Str::slug($request->name);

        // ensure unique slug
        $originalSlug = $slug;
        $count = 1;

        while (Room::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $room = Room::create([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => auth()->id(),
        ]);

        return redirect('/dashboard');
    }

    public function join($id)
    {
        $room = Room::findOrFail($id);
        $room->users()->syncWithoutDetaching(auth()->id());

        return redirect('/rooms/' . $room->slug);
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);

        if ($room->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $room->delete();

        return redirect()->back()->with('success', 'Room deleted');
    }
}
