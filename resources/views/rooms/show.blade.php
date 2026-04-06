<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">
            Room: {{ $room->name }}
        </h2>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600 mb-2">Users in room:</p>

            @foreach($room->users as $user)
                <p class="text-sm">• {{ $user->name }}</p>
            @endforeach
        </div>
    </div>
</x-app-layout>