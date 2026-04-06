<!DOCTYPE html>
<html>
<head>
    <title>Room Chat</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Laravel Echo + Pusher -->
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="flex flex-col h-screen">

    <!-- HEADER -->
    <div class="bg-gray-800 p-4 text-center font-bold text-lg">
        Room: {{ $room->name }}
    </div>

    <!-- CHAT BOX -->
    <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-2">

        @foreach($messages as $msg)
            <div>
                <b>{{ $msg->user->name }}:</b>
                {{ $msg->message }}
            </div>
        @endforeach

    </div>

    <!-- MESSAGE INPUT -->
    <div class="bg-gray-800 p-4 flex gap-2">

        <input 
            type="text" 
            id="message"
            class="flex-1 p-2 rounded bg-gray-700 text-white outline-none"
            placeholder="Type message..."
        >

        <button 
            onclick="sendMessage()"
            class="bg-blue-500 px-4 py-2 rounded"
        >
            Send
        </button>

    </div>

</div>

<script>
    // ✅ Setup Echo (same as your private chat)
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    // ✅ Listen Room Channel
    Echo.channel('room.{{ $room->id }}')
        .listen('.room.message', (e) => {

            let chatBox = document.getElementById('chat-box');

            let html = `
                <div>
                    <b>${e.message.user.name}:</b>
                    ${e.message.message}
                </div>
            `;

            chatBox.innerHTML += html;

            // auto scroll
            chatBox.scrollTop = chatBox.scrollHeight;
        });

    // ✅ Send Message Function
    function sendMessage() {
        let input = document.getElementById('message');
        let message = input.value;

        if(message.trim() === '') return;

        axios.post('/room/{{ $room->id }}/send', {
            message: message
        })
        .then(() => {
            input.value = '';
        });
    }

    // ✅ Enter key support
    document.getElementById('message').addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });
</script>

</body>
</html>