<!-- OVERLAY -->
<div id="overlay"
     class="fixed inset-0 bg-black/50 hidden z-40 md:hidden"
     onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-72 bg-gray-900 p-5 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">

    <h2 class="text-xl font-bold mb-6">💬 Chat App</h2>

    <nav class="space-y-2">

        <a href="/users" class="block px-4 py-3 rounded-lg hover:bg-gray-700">
            👥 Users
        </a>

        <a href="/requests"
           class="block px-4 py-3 rounded-lg hover:bg-gray-700">
            📩 Requests
        </a>

        <a href="/friends"
           class="block px-4 py-3 rounded-lg hover:bg-gray-700">
            🤝 Friends
        </a>

        <a href="/rooms"
           class="block px-4 py-3 rounded-lg hover:bg-gray-700">
            💬 Rooms
        </a>

    </nav>

    <form method="POST" action="/logout" class="mt-6">
        @csrf
        <button class="w-full bg-red-500 py-2 rounded-lg">
            Logout
        </button>
    </form>

</aside>