<div class="w-full px-3 sm:px-4 py-4 space-y-6">

    {{-- FORM CARD --}}
    <div class="w-full bg-white shadow-lg rounded-xl border border-gray-200 p-4 space-y-4">
        <h1 class="text-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-file-pen text-indigo-600 text-lg"></i>
            Add New Post
        </h1>

        @if (session('success'))
            <div class="p-2 rounded-lg bg-green-50 text-green-700 border border-green-200 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                {{-- Title --}}
                <div class="space-y-0.5">
                    <label class="text-xs font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="title"
                        class="border border-gray-300 rounded-lg w-full p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="space-y-0.5">
                    <label class="text-xs font-medium text-gray-700">Slug</label>
                    <input type="text" wire:model="slug"
                        class="border border-gray-300 rounded-lg w-full p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('slug')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Content --}}
            <div class="space-y-0.5">
                <label class="text-xs font-medium text-gray-700">Content</label>
                <textarea wire:model="content" rows="4"
                    class="border border-gray-300 rounded-lg w-full p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-2">
                <button type="submit" wire:click="save" wire:loading.attr="disabled" wire:target="save"
                    class="bg-indigo-600 hover:bg-indigo-700 transition text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 disabled:opacity-50 shadow-md hover:shadow-lg">
                    
                    {{-- Spinner --}}
                    <span wire:loading wire:target="save" class="animate-spin-fast">
                        <i class="fas fa-circle-notch"></i>
                    </span>

                    {{-- Button text --}}
                    <span wire:loading.remove wire:target="save">
                        <i class="fa-solid fa-save"></i> Save Post
                    </span>
                    <span wire:loading wire:target="save">
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE CARD --}}
    <div class="w-full bg-white shadow-lg rounded-xl border border-gray-200 p-4 space-y-4">
        <h2 class="text-lg font-bold flex items-center gap-2">
            <i class="fa-solid fa-table-list text-indigo-600 text-base"></i>
            All Posts
        </h2>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full text-xs divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left font-semibold text-gray-700">Title</th>
                        <th class="p-2 text-left font-semibold text-gray-700 hidden sm:table-cell">Slug</th>
                        <th class="p-2 text-left font-semibold text-gray-700 hidden md:table-cell">Content</th>
                        <th class="p-2 text-center font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-indigo-50 transition-colors">
                            <td class="p-2 break-words text-sm font-medium text-gray-900">{{ $post->title }}</td>
                            <td class="p-2 text-gray-500 break-words hidden sm:table-cell">{{ $post->slug }}</td>
                            <td class="p-2 text-gray-600 break-words hidden md:table-cell">{{ Str::limit($post->content, 80) }}</td>
                            <td class="p-2 text-center">
                                {{-- NOTE: This still uses the forbidden 'confirm', ideally this would be replaced with a modal in a full app --}}
                                <button
                                    onclick="confirm('Are you sure you want to delete this post?') || event.stopImmediatePropagation()"
                                    wire:click="deletePost({{ $post->id }})" wire:loading.attr="disabled"
                                    wire:target="deletePost({{ $post->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center justify-center gap-1 disabled:opacity-50 transition-colors mx-auto shadow-sm">
                                    <i class="fa-solid fa-trash text-white"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500 text-sm">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>