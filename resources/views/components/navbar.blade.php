<!-- Navbar -->
<nav class="bg-zinc-950 p-4">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="#" class="text-white text-2xl font-bold">RadioStation</a>
            </div>

            <!-- Navigation links -->
            <div class="hidden sm:flex sm:items-center space-x-4">
                <a href="{{ route('stations.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-lg font-bold">Home</a>
                <a href="{{ route('stations.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-lg font-bold">Stations</a>
                <a href="{{ route('stations.create') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-lg font-bold">Share a Station</a>
                <a href="#" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-lg font-bold">Contact</a>

                <!-- Auth Avatar with Dropdown -->
@auth
<div class="relative group">
    <!-- Circle Avatar -->
    <button class="w-10 h-10 rounded-full bg-indigo-600 overflow-hidden border-2 border-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" alt="User Avatar" class="w-full h-full object-cover">
    </button>

    <!-- Dropdown Menu -->
<div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50 hidden group-hover:block">
    @if(!Auth::user()->is_email_verified)
        <div class="px-4 py-2 text-sm text-red-600 font-semibold">
            Email not verified
        </div>
        <hr class="border-gray-200 my-1">
    @endif

    <a href="{{ route('stations.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Favorite Stations</a>
    <a href="{{ route('stations.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Share a Station</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
    </form>
</div>

</div>
@else
<a href="{{ route('loginView') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 text-white hover:bg-gray-600 transition duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
</a>
@endauth

            </div>

            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 right-0 flex items-center sm:hidden">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="sm:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('stations.index') }}" class="text-white block px-3 py-2 rounded-md text-lg font-medium">Home</a>
            <a href="{{ route('stations.index') }}" class="text-white block px-3 py-2 rounded-md text-lg font-medium">Stations</a>
            <a href="{{ route('stations.create') }}" class="text-white block px-3 py-2 rounded-md text-lg font-medium">Share a Station</a>
            <a href="#" class="text-white block px-3 py-2 rounded-md text-lg font-medium">Contact</a>
            @auth
                <a href="{{ route('stations.index') }}" class="text-white block px-3 py-2 rounded-md text-lg font-medium">Favorite Stations</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-white block w-full text-left px-3 py-2 rounded-md text-lg font-medium">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', () => {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
