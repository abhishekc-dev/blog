@extends('layouts.main')

@section('title', 'Posts List')

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Posts List</h1>
        <!-- Search Form -->
        <form id="search-form" action="{{ url('/dashboard') }}" method="GET" class="flex space-x-2">
            <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                class="border border-gray-300 rounded px-4 py-2" placeholder="Search posts...">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Search
            </button>
        </form>
    </div>

    <!-- Error and success messages -->
    <div id="message-box" class="mb-4 hidden">
        <div id="success-message"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Action completed successfully.</span>
        </div>
        <div id="error-message"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">An error occurred.</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-200 border-b border-gray-300">
                <tr>
                    <th class="py-3 px-6 text-left text-gray-600">Title</th>
                    <th class="py-3 px-6 text-left text-gray-600">Content</th>
                    <th class="py-3 px-6 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody id="posts-table-body">
                @foreach($posts as $post)
                    <tr data-id="{{ $post->id }}" class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-gray-800">
                            <h2 class="text-xl font-semibold">
                                <a href="javascript:void(0);" class="text-blue-500 hover:underline view-post"
                                    data-id="{{ $post->id }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                        </td>
                        <td class="py-3 px-6 text-gray-700">
                            {{ Str::limit($post->content, 100) }}
                        </td>
                        <td class="py-3 px-6 flex space-x-2">
                            <a href="javascript:void(0);" class="text-blue-500 hover:text-blue-700 view-post"
                                data-id="{{ $post->id }}">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if($post->author_id === Auth::id())
                                <a href="javascript:void(0);" class="text-green-500 hover:text-green-700 edit-post"
                                    data-id="{{ $post->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="javascript:void(0);" class="text-red-500 hover:text-red-700 delete-post"
                                    data-id="{{ $post->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            @else
                                <span class="text-gray-500">No actions available</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    <!-- View Post Modal -->
    <div id="view-post-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-4">View Post</h2>
            <div id="post-author" class="mb-2 text-gray-700"></div>
            <div id="post-created-at" class="mb-2 text-gray-700"></div>
            <div id="post-details"></div>
            <!-- Display comments -->
            <div id="post-comments" class="mt-4"></div>

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
            <button id="close-view-modal"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
        </div>
    </div>

    <!-- Edit Post Modal -->
    <div id="edit-post-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-4">Edit Post</h2>
            <form id="edit-post-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-title" class="block text-gray-700">Title</label>
                    <input type="text" id="edit-title" name="title"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit-content" class="block text-gray-700">Content</label>
                    <textarea id="edit-content" name="content" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancel-edit"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit"
                        class="ml-3 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>

@section('scripts')
<script>
    $(document).ready(function () {
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            const query = $('#search-input').val();
            $.ajax({
                url: $(this).attr('action'),
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    $('#posts-table-body').html(response.html);
                    $('.pagination').html(response.pagination);
                },
                error: function () {
                    $('#error-message').removeClass('hidden').find('span').text('Error searching posts.');
                }
            });
        });

        $(document).on('click', '.view-post', function () {
            const postId = $(this).data('id');
            $.ajax({
                url: `/posts/${postId}`,
                type: 'GET',
                success: function (response) {
                    $('#post-details').html(`
                    Title : <h1 class="text-2xl font-semibold my-4">${response.title}</h1>
                    <hr/>
                    <p>${response.content}</p>
                `);
                    $('#post-author').text(`Author: ${response.user.name}`);
                    $('#post-created-at').text(`Created At: ${new Date(response.created_at).toLocaleDateString()}`);

                    let commentsHtml = '';
                    response.comments.forEach(comment => {
                        commentsHtml += `<div class="border-b border-gray-200 py-2">
                            <p><strong>${comment.user.name}:</strong> ${comment.content}</p>
                        </div>`;
                    });
                    $('#post-comments').html(commentsHtml || '<p>No comments yet.</p>');

                    $('#view-post-modal').removeClass('hidden');
                },
                error: function () {
                    $('#error-message').removeClass('hidden').find('span').text('Error loading post details.');
                }
            });
        });

        $(document).on('submit', 'form[id^="comment-form-"]', function (e) {
            e.preventDefault();
            const form = $(this);
            const postId = form.data('post-id');

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
                        $(`#comment-content-${postId}`).val('');
                        location.reload();
                    } else {
                        console.error('User not found in response');
                    }
                },
                error: function () {
                    $('#error-message').removeClass('hidden').find('span').text('Error posting comment.');
                }
            });
        });


        $(document).on('click', '#close-view-modal', function () {
            $('#view-post-modal').addClass('hidden');
        });

        $(document).on('click', '.edit-post', function () {
            const postId = $(this).data('id');
            $.ajax({
                url: `/posts/${postId}/edit`,
                type: 'GET',
                success: function (response) {
                    $('#edit-title').val(response.title);
                    $('#edit-content').val(response.content);
                    $('#edit-post-form').attr('action', `/posts/${postId}`);
                    $('#edit-post-modal').removeClass('hidden');
                },
                error: function () {
                    $('#error-message').removeClass('hidden').find('span').text('Error loading the edit form.');
                }
            });
        });

        $(document).on('submit', '#edit-post-form', function (e) {
            e.preventDefault();
            const form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function () {
                    $('#success-message').removeClass('hidden').find('span').text('Post updated successfully.');
                    $('#edit-post-modal').addClass('hidden');
                    location.reload();
                },
                error: function () {
                    $('#error-message').removeClass('hidden').find('span').text('Error updating the post.');
                }
            });
        });

        $(document).on('click', '#cancel-edit', function () {
            $('#edit-post-modal').addClass('hidden');
        });

        $(document).on('click', '.delete-post', function (e) {
            e.preventDefault();
            const postId = $(this).data('id');
            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    url: `/posts/${postId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        $(`tr[data-id="${postId}"]`).remove(); // Remove the row or update the UI
                        $('#success-message').removeClass('hidden').find('span').text('Post deleted successfully.');
                    },
                    error: function () {
                        $('#error-message').removeClass('hidden').find('span').text('Error deleting the post.');
                    }
                });
            }
        });
    });
</script>
@endsection
@endsection