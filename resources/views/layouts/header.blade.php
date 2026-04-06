<header class="bg-gray-800 px-4 py-3 flex items-center justify-between">

    <div class="flex items-center gap-3">

        <!-- MOBILE MENU -->
        <button class="md:hidden text-2xl" onclick="toggleSidebar()">
            ☰
        </button>

        <h1 class="text-lg font-semibold">
            @yield('title', 'Dashboard')
        </h1>

    </div>

    <div class="flex items-center gap-3">

        <span class="hidden sm:block text-sm">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="/logout">
            @csrf
            <button class="bg-red-500 px-3 py-1.5 rounded text-sm">
                Logout
            </button>
        </form>

    </div>

</header>