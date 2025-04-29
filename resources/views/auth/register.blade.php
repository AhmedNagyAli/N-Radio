@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-white px-6 py-12">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-16 space-y-10">
        <div class="text-center">
            <h2 class="text-5xl font-extrabold text-indigo-600">Create Your Account</h2>
            <p class="text-xl text-gray-500 mt-4">Join us and get started today</p>
        </div>

        <form method="POST" action="/register" class="space-y-6 text-lg">
            @csrf

            <div>
                <label for="name" class="block text-xl font-semibold text-gray-700 mb-2">Full Name</label>
                <input
                    name="name"
                    type="text"
                    placeholder="John Doe"
                    maxlength="50"
                    required
                    class="block w-full px-6 py-4 border border-gray-300 rounded-xl shadow-sm text-xl focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="email" class="block text-xl font-semibold text-gray-700 mb-2">Email Address</label>
                <input
                    name="email"
                    type="email"
                    placeholder="john@example.com"
                    required
                    class="block w-full px-6 py-4 border border-gray-300 rounded-xl shadow-sm text-xl focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="password" class="block text-xl font-semibold text-gray-700 mb-2">Password</label>
                <input
                    name="password"
                    type="password"
                    placeholder="••••••••"
                    required
                    class="block w-full px-6 py-4 border border-gray-300 rounded-xl shadow-sm text-xl focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-xl font-semibold text-gray-700 mb-2">Confirm Password</label>
                <input
                    name="password_confirmation"
                    type="password"
                    placeholder="••••••••"
                    required
                    class="block w-full px-6 py-4 border border-gray-300 rounded-xl shadow-sm text-xl focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full py-4 px-6 text-xl font-bold bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Register
                </button>
            </div>
        </form>

        <p class="text-center text-lg text-gray-600">
            Already have an account?
            <a href="/login" class="text-blue-600 hover:underline font-semibold">Login here</a>
        </p>
    </div>
</div>
@endsection
