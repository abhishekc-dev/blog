@extends('layouts.main')

@section('title', 'Create a New Post')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">Create a New Post</h1>

    <!-- Error messages will be displayed here -->
    <div id="error-messages"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">Please correct the following errors:</span>
        <ul id="error-list" class="list-disc pl-5 mt-2">
        </ul>
    </div>

    <!-- Success message will be displayed here -->
    <div id="success-message"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">Your post has been created.</span>
    </div>

    <form id="create-post-form" method="POST" action="{{ url('/posts') }}" class="space-y-4">
        @csrf
        <div class="form-group">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title:</label>
            <input type="text" id="title" name="title"
                class="form-control form-input w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="form-group">
            <label for="content" class="block text-gray-700 font-medium mb-2">Content:</label>
            <textarea id="content" name="content"
                class="form-control form-textarea w-full border-gray-300 rounded-md shadow-sm" rows="10"></textarea>
        </div>

        <button type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            Create Post
        </button>
    </form>

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#create-post-form').on('submit', function (e) {
                e.preventDefault();

                $('#error-messages').addClass('hidden');
                $('#success-message').addClass('hidden');
                $('#error-list').empty();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#success-message').removeClass('hidden');
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        $('#error-messages').removeClass('hidden');
                        for (let key in errors) {
                            $('#error-list').append('<li>' + errors[key][0] + '</li>');
                        }
                    }
                });
            });
        });
    </script>
    @endsection
    @endsection