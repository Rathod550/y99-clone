<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">

        <!-- HEADER -->
        <div class="bg-white shadow p-4 rounded mb-4 flex justify-between items-center">
            <h2 class="font-bold text-lg">
                Chat with {{ $user->name }}
            </h2>

            <a href="/dashboard" class="text-blue-500 text-sm"> 
                ← Back
            </a>
        </div>

        <!-- MESSAGES -->
        <div class="messages-box bg-white shadow p-4 rounded h-96 overflow-y-auto mb-4">

            @foreach($messages as $msg)
                @if($msg->sender_id == auth()->id())
                    <!-- SENT -->
                    <div class="mb-2 text-right">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded inline-block">
                            {{ $msg->message }}
                        </span>
                    </div>
                @else
                    <!-- RECEIVED -->
                    <div class="mb-2 text-left">
                        <span class="bg-gray-300 px-3 py-1 rounded inline-block">
                            {{ $msg->message }}
                        </span>
                    </div>
                @endif
            @endforeach

        </div>

        <!-- SEND MESSAGE -->
        <form id="chat-form">
            @csrf

            <div class="flex gap-2">
                <input type="text" name="message"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Type message..." required>

                <button type="submit"
                        class="bg-blue-500 text-white px-4 rounded hover:bg-blue-600">
                    Send
                </button>
            </div>
        </form>

    </div>

    <!-- REAL-TIME + AJAX SCRIPT -->
    <script>
		document.addEventListener("DOMContentLoaded", function () {

		    console.log('🚀 Chat script loaded AFTER DOM');

		    // CHECK ECHO
		    if (typeof Echo === 'undefined') {
		        console.error('❌ Echo still NOT loaded');
		        return;
		    } else {
		        console.log('✅ Echo is loaded properly');
		    }

		    // SEND MESSAGE
		    document.getElementById('chat-form').addEventListener('submit', function(e){
		        e.preventDefault();

		        let input = document.querySelector('input[name=message]');
		        let message = input.value;

		        fetch('/chat/{{ $user->id }}', {
		            method: 'POST',
		            headers: {
		                'Content-Type': 'application/json',
		                'X-CSRF-TOKEN': '{{ csrf_token() }}'
		            },
		            body: JSON.stringify({ message: message })
		        });

		        let box = document.querySelector('.messages-box');

		        box.innerHTML += `
		            <div class="mb-2 text-right">
		                <span class="bg-blue-500 text-white px-3 py-1 rounded inline-block">
		                    ${message}
		                </span>
		            </div>
		        `;

		        input.value = '';
		        box.scrollTop = box.scrollHeight;
		    });

		    // LISTEN
		    console.log('👂 Subscribing to: chat.{{ auth()->id() }}');

		    Echo.channel('chat.{{ auth()->id() }}')
		        .listen('.message.sent', (e) => {
		            console.log("🔥 RECEIVED:", e);

		            let box = document.querySelector('.messages-box');

		            box.innerHTML += `
		                <div class="mb-2 text-left">
		                    <span class="bg-gray-300 px-3 py-1 rounded inline-block">
		                        ${e.message.message}
		                    </span>
		                </div>
		            `;

		            box.scrollTop = box.scrollHeight;
		        });

		});
	</script>
</x-app-layout>