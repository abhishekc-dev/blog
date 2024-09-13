@extends('layouts.main')

@section('content')
<div id="edit-post-form-container" class="hidden">
    <h1 class="text-3xl font-bold mb-6">Edit Post</h1>

    <form id="edit-post-form" method="POST" action="" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title:</label>
            <input type="text" id="edit-title" name="title"
                class="form-control form-input w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="form-group">
            <label for="content" class="block text-gray-700 font-medium mb-2">Content:</label>
            <textarea id="edit-content" name="content"
                class="form-control form-textarea w-full border-gray-300 rounded-md shadow-sm" rows="10"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Update Post
        </button>
    </form>
</div>
@endsection