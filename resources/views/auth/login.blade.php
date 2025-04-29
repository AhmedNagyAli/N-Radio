@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-white px-6 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-10 space-y-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-indigo-600">Login</h2>
            <p class="text-gray-500 mt-2 text-lg">Welcome back! Please enter your credentials.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input
                    name="email"
                    type="email"
                    required
                    placeholder="you@example.com"
                    class="mt-1 block w-full px-5 py-3 text-lg border border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input
                    name="password"
                    type="password"
                    required
                    placeholder="••••••••"
                    class="mt-1 block w-full px-5 py-3 text-lg border border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full py-3 px-6 text-lg font-semibold bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Sign In
                </button>
            </div>
        </form>

        <p class="text-center text-gray-600 text-md">
            Don't have an account?
            <a href="/register" class="text-indigo-600 hover:underline font-semibold">Register</a>
        </p>
    </div>
</div>
@endsection
