@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="space-y-3">

@foreach($users as $user)

    <div class="bg-gray-800 p-4 rounded-xl flex items-center justify-between">

        <!-- USER INFO -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <div class="font-medium">{{ $user->name }}</div>
                <div class="text-xs text-gray-400">Available</div>
            </div>
        </div>

        <!-- 🔥 FRIEND LOGIC -->
        @php
            $relation = $friends->first(function ($f) use ($user) {
                return ($f->sender_id == auth()->id() && $f->receiver_id == $user->id)
                    || ($f->receiver_id == auth()->id() && $f->sender_id == $user->id);
            });
        @endphp

        @if(!$relation)

            <a href="/friends/send/{{ $user->id }}"
               class="bg-blue-500 px-4 py-2 rounded-lg text-sm">
                Add
            </a>

        @elseif($relation->status == 'pending')

            @if($relation->sender_id == auth()->id())

                <span class="text-yellow-400 text-sm">Pending</span>

            @else

                <div class="flex gap-2">
                    <a href="/friends/accept/{{ $relation->id }}"
                       class="bg-green-500 px-3 py-1 rounded text-sm">
                        Accept
                    </a>

                    <a href="/friends/reject/{{ $relation->id }}"
                       class="bg-red-500 px-3 py-1 rounded text-sm">
                        Reject
                    </a>
                </div>

            @endif

        @elseif($relation->status == 'accepted')

            <a href="/chat/{{ $user->id }}"
               class="bg-green-500 px-4 py-2 rounded-lg text-sm">
                Chat
            </a>

        @endif

    </div>

@endforeach

</div>

@endsection