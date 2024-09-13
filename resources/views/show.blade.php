<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Blog Post</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <header class="bg-white shadow-md border-b border-gray-200">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div class="space-x-4">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline">Home</a>
            </div>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
                    <a href="{{ route('logout') }}" class="text-blue-500 hover:underline"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <div class="mb-4">
            <a href="{{ url('/') }}" class="text-blue-500 hover:underline">&larr; Back to Home</a>
        </div>

        <article class="bg-white shadow-md rounded-lg border border-gray-200 p-6 mb-4">
            <h1 class="text-3xl font-bold text-blue-500 mb-4 text-center">{{ $post->title }}</h1>
            <span class="text-blue-500 mb-4">Created at ></span> <b>{{ $post->created_at }}</b><br /><br />
            <span class="text-blue-500 mb-4">Author Name ></span> <b>{{ $post->user->name }}</b><br /><br />
            <div class="text-gray-700">
                {!! nl2br(e($post->content)) !!}
            </div>
            <div class="">
                <div id="post-comments-{{ $post->id }}" class="mt-4">
                    <h3 class="text-lg font-semibold mb-2">Comments</h3>
                    @foreach($post->comments as $comment)
                        <div class="mb-2 border-b border-gray-200 pb-2">
                            <p class="text-gray-700">{{ $comment->content }}</p>
                            <small class="text-gray-500">by {{ $comment->user->name }} on
                                {{ $comment->created_at->format('F j, Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </article>
    </main>
</body>

</html>