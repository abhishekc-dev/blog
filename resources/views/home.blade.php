<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Home</title>
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
        @if(session('success'))
            <div class="alert alert-green">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-center">
            <marquee behavior="alternate-reverse" scrollamount="20">
                <h1 class="text-3xl font-bold mb-2 text-blue-500">Welcome to my Blog Website</h1>
            </marquee>
        </div>

        @foreach($posts as $post)
            <article class="bg-white shadow-md rounded-lg border border-gray-200 p-6 mb-4">
                <h2 class="text-xl font-semibold text-blue-500 mb-2">
                    <a href="{{ url('/post/' . $post->id) }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
                <p class="text-gray-700">{{ $post->content }}</p>

                <!-- Display comments -->
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

                <!-- Comment form for logged-in users only -->
                @auth
                    <form id="comment-form-{{ $post->id }}" class="mt-4" data-post-id="{{ $post->id }}">
                        @csrf
                        <textarea name="content" id="comment-content-{{ $post->id }}"
                            class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Add a comment..."
                            required></textarea>
                        <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Post Comment
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 mt-2">You must be <a href="{{ route('login') }}" class="text-blue-500">logged in</a>
                        to post a comment.</p>
                @endauth
            </article>
        @endforeach

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('submit', 'form[id^="comment-form-"]', function (e) {
                e.preventDefault();
                const form = $(this);
                const postId = form.data('post-id');
                const commentContent = form.find('textarea').val();

                $.ajax({
                    url: `/comments/${postId}`,
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.user) {
                            $(`#post-comments-${postId}`).append(`
                                <div class="border-b border-gray-200 py-2">
                                    <p><strong>${response.user.name}:</strong> ${response.content}</p>
                                </div>
                            `);
                            form.find('textarea').val('');

                            // Optionally close the modal if you are using one
                            // $('#view-post-modal').addClass('hidden')
                        } else {
                            console.error('User not found in response');
                        }
                    },
                    error: function () {
                        alert('Error posting comment.');
                    }
                });
            });
        });
    </script>
</body>

</html>