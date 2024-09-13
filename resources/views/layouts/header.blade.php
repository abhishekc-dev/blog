<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@heroicons/vue@1.0.6/outline.js" defer></script>
</head>

<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4">
                <ul>
                    <li>
                        <a href="{{ url('/') }}" class="block py-2 px-4 text-blue-500 hover:bg-gray-200">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/posts/create') }}"
                            class="block py-2 px-4 text-blue-500 hover:bg-gray-200">Create New Post</a>
                    </li>

                    @guest
                        <li>
                            <a href="{{ route('register') }}"
                                class="block py-2 px-4 text-blue-500 hover:bg-gray-200">Register</a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="block py-2 px-4 text-blue-500 hover:bg-gray-200">Login</a>
                        </li>
                    @endguest

                    @auth
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="block px-4 text-blue-500 hover:bg-gray-200">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </aside>