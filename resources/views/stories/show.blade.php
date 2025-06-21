@extends('layouts.app')

@section('title', $story->judul)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Story Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <!-- Cover Image -->
        @if($story->cover_image)
        <div class="h-64 w-full overflow-hidden">
            <img src="{{ asset('storage/'.$story->cover_image) }}" 
                 alt="{{ $story->judul }}" 
                 class="w-full h-full object-cover">
        </div>
        @endif

        <!-- Story Meta -->
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <img class="h-10 w-10 rounded-full" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($story->author->nama_lengkap) }}&background=indigo&color=white" 
                         alt="{{ $story->author->nama_lengkap }}">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $story->author->nama_lengkap }}</p>
                        <p class="text-sm text-gray-500">{{ $story->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    {{ $story->genre }}
                </span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $story->judul }}</h1>
            <p class="text-gray-700">{{ $story->deskripsi }}</p>

            @if($isOwner)
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('chapters.create', ['story_id' => $story->id]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    Add Chapter
                </a>
                <a href="{{ route('stories.edit', ['id' => $story->id]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Edit Story
                </a>
                <form action="{{ route('stories.destroy', ['id' => $story->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700"
                            onclick="return confirm('Delete this story?')">
                        Delete Story
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Chapters List -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Chapters</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($story->chapters as $chapter)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-center">
                    <a href="{{ route('chapters.show', ['story_slug' => $story->slug, 'chapter_slug' => $chapter->slug]) }}" 
                       class="block flex-grow">
                        <h3 class="text-lg font-medium text-indigo-600 hover:text-indigo-800">{{ $chapter->judul }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Posted {{ $chapter->created_at->diffForHumans() }}</p>
                    </a>
                    @if($isOwner)
                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('chapters.edit', ['story_id' => $story->id, 'chapter_id' => $chapter->id]) }}" 
                           class="text-sm bg-yellow-100 text-yellow-800 px-2 py-1 rounded hover:bg-yellow-200">
                            Edit
                        </a>
                        <form action="{{ route('chapters.destroy', ['story_id' => $story->id, 'chapter_id' => $chapter->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded hover:bg-red-200"
                                    onclick="return confirm('Delete this chapter?')">
                                Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                No chapters yet.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection