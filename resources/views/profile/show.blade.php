@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <img class="h-20 w-20 rounded-full" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=indigo&color=white&size=128" 
                             alt="{{ $user->nama_lengkap }}">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->nama_lengkap }}</h1>
                        <p class="text-gray-600">{{ '@' . $user->username }}</p>
                        <p class="text-sm text-gray-500 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- My Stories -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Cerita Saya</h2>
            <a href="{{ route('stories.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Cerita Baru
            </a>
        </div>

        @if($stories->isEmpty())
        <div class="bg-white rounded-xl shadow-md overflow-hidden text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada cerita nih</h3>
            <p class="mt-1 text-gray-500">Yuk, mulai buat cerita pertamamu!</p>
            <div class="mt-6">
                <a href="{{ route('stories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Cerita Baru
                </a>
            </div>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($stories as $story)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Cover Image -->
                    <div class="h-40 relative overflow-hidden">
                        <img src="{{ $story->cover_image ? asset('storage/'.$story->cover_image) : 'https://source.unsplash.com/random/600x400?fantasy' }}" 
                             alt="{{ $story->judul }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="inline-block px-2 py-1 bg-indigo-600 text-white text-xs font-semibold rounded">{{ $story->genre }}</span>
                        </div>
                    </div>
                    
                    <!-- Story Content -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $story->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $story->deskripsi }}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ $story->chapters_count }} {{ Str::plural('chapter', $story->chapters_count) }}
                            </span>
                            <div class="flex space-x-2">
                                <a href="{{ route('stories.show', $story->slug) }}" 
                                   class="text-xs bg-blue-100 text-white-800 px-2 py-1 rounded hover:bg-blue-200">
                                    Lihat
                                </a>
                                <a href="{{ route('stories.edit', $story->id) }}" 
                                   class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded hover:bg-yellow-200">
                                    Edit
                                </a>
                                <form action="{{ route('stories.destroy', $story->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded hover:bg-red-200"
                                            onclick="return confirm('Delete this story?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection