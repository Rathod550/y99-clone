<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col w-full md:ml-72">

        @include('layouts.header')

        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

    </div>

</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>

</body>
</html>