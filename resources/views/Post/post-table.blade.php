<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
    <thead class="bg-gray-200 border-b border-gray-300">
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
                    <a href="javascript:void(0);" class="text-green-500 hover:text-green-700 edit-post"
                        data-id="{{ $post->id }}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="javascript:void(0);" class="text-red-500 hover:text-red-700 delete-post"
                        data-id="{{ $post->id }}">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>