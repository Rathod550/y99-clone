<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- LEFT: USERS -->
            <div class="bg-white shadow rounded-xl p-4">
                <h3 class="font-bold text-lg mb-4">All Users</h3>

                @forelse($users as $user)
                    <div class="flex justify-between items-center border-b py-2">

                        <div>
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->username }}</p>
                        </div>

                        @php
                            $status = null;

                            // Check if already friends
                            foreach($friends as $f){
                                if(
                                    ($f->sender_id == auth()->id() && $f->receiver_id == $user->id) ||
                                    ($f->receiver_id == auth()->id() && $f->sender_id == $user->id)
                                ){
                                    $status = 'friends';
                                }
                            }

                            // Check if request sent
                            foreach($requests as $r){
                                if($r->sender_id == auth()->id() && $r->receiver_id == $user->id){
                                    $status = 'sent';
                                }
                            }
                        @endphp

                        @if($status == 'friends')
                            <span class="text-green-600 text-sm font-semibold">Friends</span>

                        @elseif($status == 'sent')
                            <span class="text-yellow-500 text-sm font-semibold">Request Sent</span>

                        @else
                            <a href="/friends/send/{{ $user->id }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                Add
                            </a>
                        @endif

                    </div>
                @empty
                    <p class="text-gray-500">No users found</p>
                @endforelse
            </div>

            <!-- MIDDLE: FRIEND REQUESTS -->
            <div class="bg-white shadow rounded-xl p-4">
                <h3 class="font-bold text-lg mb-4">Friend Requests</h3>

                @forelse($requests as $req)
                    <div class="flex justify-between items-center border-b py-2">

                        <div>
                            <p class="font-medium">{{ $req->sender->name }}</p>
                            <p class="text-sm text-gray-500">{{ $req->sender->username }}</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="/friends/accept/{{ $req->id }}"
                               class="bg-green-500 text-white px-2 py-1 rounded text-sm hover:bg-green-600">
                                Accept
                            </a>

                            <a href="/friends/reject/{{ $req->id }}"
                               class="bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">
                                Reject
                            </a>
                        </div>

                    </div>
                @empty
                    <p class="text-gray-500">No pending requests</p>
                @endforelse
            </div>

            <!-- RIGHT: FRIEND LIST -->
            <div class="bg-white shadow rounded-xl p-4">
                <h3 class="font-bold text-lg mb-4">Friends</h3>

                @forelse($friends as $f)

                    @php
                        $friendUser = $f->sender_id == auth()->id() ? $f->receiver : $f->sender;
                    @endphp

                    <div class="flex justify-between items-center border-b py-2">
                        <div>
                            <p class="font-medium">{{ $friendUser->name }}</p>
                            <p class="text-sm text-gray-500">{{ $friendUser->username }}</p>
                        </div>

                        <a href="/chat/{{ $friendUser->id }}"
                           class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                            Chat
                        </a>
                    </div>

                @empty
                    <p class="text-gray-500">No friends yet</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>