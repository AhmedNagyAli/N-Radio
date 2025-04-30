<footer class="bg-zinc-950 text-white py-10 mt-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Logo & Description -->
        <div>
            <h2 class="text-2xl font-bold mb-3">RadioStation</h2>
            <p class="text-gray-400 text-sm">Streaming your favorite stations around the clock. Discover, share, and enjoy music from everywhere.</p>
        </div>

        <!-- Navigation Links -->
        <div>
            <h3 class="text-lg font-bold mb-3">Navigation</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="{{ route('stations.index') }}" class="hover:text-white">Home</a></li>
                <li><a href="{{ route('stations.index') }}" class="hover:text-white">Stations</a></li>
                <li><a href="{{ route('stations.create') }}" class="hover:text-white">Share a Station</a></li>
                <li><a href="#" class="hover:text-white">Contact</a></li>
            </ul>
        </div>

        <!-- User Links -->
        <div>
            <h3 class="text-lg font-bold mb-3">Account</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                @auth
                    <li><a href="{{ route('stations.index') }}" class="hover:text-white">Favorite Stations</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-white">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('loginView') }}" class="hover:text-white">Login</a></li>
                @endauth
            </ul>
        </div>

        <!-- Social & Newsletter -->
        <div>
            <h3 class="text-lg font-bold mb-3">Stay Connected</h3>
            <div class="flex space-x-4 mb-4">
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <form class="flex">
                <input type="email" placeholder="Email address" class="w-full px-3 py-2 text-black rounded-l-md focus:outline-none">
                <button class="bg-indigo-600 px-4 py-2 rounded-r-md hover:bg-indigo-700">Subscribe</button>
            </form>
        </div>

    </div>

    <div class="border-t border-zinc-800 mt-10 pt-6 text-center text-sm text-gray-500">
        &copy; {{ now()->year }} RadioStation. All rights reserved.
    </div>
</footer>
