@extends('layouts.app')

@section('content')

<div class="p-4 text-white">

    <h2 class="text-lg font-bold mb-4">Friend Requests</h2>

    @forelse($requests as $req)
        <div class="flex justify-between items-center bg-gray-800 p-3 rounded mb-3">

            <div>
                <p class="font-semibold">{{ $req->sender->name }}</p>
                <p class="text-sm text-gray-400">wants to connect</p>
            </div>

            <div class="flex gap-2">
                <form action="{{ route('requests.accept', $req->id) }}" method="POST">
                    @csrf
                    <button class="bg-green-500 px-3 py-1 rounded text-sm">Accept</button>
                </form>

                <form action="{{ route('requests.reject', $req->id) }}" method="POST">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded text-sm">Reject</button>
                </form>
            </div>

        </div>
    @empty
        <p class="text-gray-400 text-center">No requests</p>
    @endforelse

</div>

@endsection