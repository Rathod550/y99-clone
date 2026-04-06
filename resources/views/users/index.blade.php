@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="space-y-3">

@foreach($users as $user)

    @if($user->id != auth()->id())

        @php
            $isFriend = $requests->first(function ($r) use ($user) {
                return (
                    ($r->sender_id == auth()->id() && $r->receiver_id == $user->id)
                    || ($r->receiver_id == auth()->id() && $r->sender_id == $user->id)
                ) && $r->status == 'accepted';
            });

            $isRequested = $requests->first(function ($r) use ($user) {
                return (
                    ($r->sender_id == auth()->id() && $r->receiver_id == $user->id)
                    || ($r->receiver_id == auth()->id() && $r->sender_id == $user->id)
                ) && $r->status == 'pending';
            });
        @endphp

        <div class="flex items-center justify-between bg-gray-800 px-4 py-3 rounded-lg">

            <!-- User Info -->
            <div>
                <p class="text-white font-medium">{{ $user->name }}</p>
                <p class="text-xs text-gray-400">Active user</p>
            </div>

            <!-- Actions -->
            <div>

                @if($isFriend)
                    <span class="text-green-400 text-xs font-semibold">
                        Friends
                    </span>

                @elseif($isRequested)
                    <span class="text-yellow-400 text-xs font-semibold">
                        Requested
                    </span>

                @else
                    <form action="{{ route('requests.send', $user->id) }}" method="POST">
                        @csrf
                        <button class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-xs font-semibold">
                            Add Friend
                        </button>
                    </form>
                @endif

            </div>

        </div>

    @endif

@endforeach

</div>

@endsection