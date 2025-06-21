@extends('layouts.app')

@section('title', $chapter->judul)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('stories.show', $story->slug) }}" 
           class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Story
        </a>
    </div>

    <!-- Chapter Content -->
    <article class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="p-6 sm:p-8 border-b border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <img class="h-10 w-10 rounded-full" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($story->author->nama_lengkap) }}&background=indigo&color=white" 
                         alt="{{ $story->author->nama_lengkap }}">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $story->author->nama_lengkap }}</p>
                        <p class="text-sm text-gray-500">{{ $chapter->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if($isOwner)
                <div class="flex space-x-3">
                    <a href="{{ route('chapters.edit', ['story_id' => $story->id, 'chapter_id' => $chapter->id]) }}" 
                       class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-500 hover:bg-yellow-600">
                        Edit
                    </a>
                    <form action="{{ route('chapters.destroy', ['story_id' => $story->id, 'chapter_id' => $chapter->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-500 hover:bg-red-600"
                                onclick="return confirm('Delete this chapter?')">
                            Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $chapter->judul }}</h1>
            <p class="text-lg text-indigo-600">From: <a href="{{ route('stories.show', $story->slug) }}" class="hover:underline">{{ $story->judul }}</a></p>
        </div>

        <!-- Illustration -->
        @if($chapter->gambar_pendukung)
        <div class="w-full px-6 sm:px-8 py-6">
            <img src="{{ asset('storage/'.$chapter->gambar_pendukung) }}" 
                 alt="Chapter illustration"
                 class="rounded-lg shadow-md w-full max-h-96 object-contain mx-auto">
        </div>
        @endif

        <!-- Content -->
        <div class="p-6 sm:p-8 prose prose-lg max-w-none font-serif text-gray-800">
            {!! Str::markdown($chapter->isi) !!}
        </div>
    </article>

    <!-- Navigation -->
    <div class="mt-8 flex justify-between">
        @if($previousChapter)
        <a href="{{ route('chapters.show', ['story_slug' => $story->slug, 'chapter_slug' => $previousChapter->slug]) }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Previous Chapter
        </a>
        @else
        <span></span>
        @endif

        @if($nextChapter)
        <a href="{{ route('chapters.show', ['story_slug' => $story->slug, 'chapter_slug' => $nextChapter->slug]) }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            Next Chapter
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        @endif
    </div>
</div>
@endsection