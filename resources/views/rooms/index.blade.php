<!DOCTYPE html>
<html>
<head>
    <title>Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Chat Rooms</h1>

    <!-- CREATE ROOM FORM -->
    <form action="/rooms/create" method="POST" class="mb-6">
        @csrf

        <div class="bg-gray-800 rounded-xl p-4 shadow-lg flex flex-col md:flex-row gap-3 items-center">

            <div class="flex-1 w-full">
                <input 
                    type="text" 
                    name="name"
                    placeholder="Create a new room..."
                    class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-green-500"
                    required
                >
            </div>

            <button class="bg-green-500 px-6 py-3 rounded-lg">
                ➕ Create Room
            </button>

        </div>
    </form>

    <!-- ROOM LIST -->
    <div class="space-y-3">
        @foreach($rooms as $room)

            @php
                $joined = $room->users->contains(auth()->id());
            @endphp

            <div class="bg-gray-800 p-4 rounded flex justify-between items-center hover:bg-gray-700">

                <div>
                    <p class="font-semibold">{{ $room->name }}</p>
                    <p class="text-sm text-gray-400">
                        {{ $room->users_count ?? 0 }} users
                    </p>
                </div>

                @if($joined)
                    <!-- ✅ ENTER -->
                    <a href="/rooms/{{ $room->slug }}" 
                       class="bg-green-500 px-4 py-2 rounded text-sm">
                        Enter
                    </a>
                @else
                    <!-- ✅ JOIN -->
                    <a href="/rooms/join/{{ $room->id }}" 
                       class="bg-blue-500 px-4 py-2 rounded text-sm">
                        Join
                    </a>
                @endif

            </div>

        @endforeach
    </div>

</div>

</body>
</html>