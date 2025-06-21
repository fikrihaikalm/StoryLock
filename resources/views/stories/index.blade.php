@extends('layouts.app')

@section('title', 'All Stories')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Temukan Cerita</h1>
        <p class="mt-2 text-lg text-gray-600">Telusuri berbagai cerita dari komunitas kami.</p>
    </div>

    <!-- Genre Filter -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('stories.index') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ !request('genre') ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Semua
            </a>
            @foreach(['Fantasy', 'Romance', 'Mystery', 'Sci-Fi', 'Horror'] as $genre)
            <a href="{{ route('stories.index', ['genre' => $genre]) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium {{ request('genre') === $genre ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                {{ $genre }}
            </a>
            @endforeach
        </div>
    </div>

    <div class="mb-8">
        @if(request('search'))
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Hasil Pencarian "{{ request('search') }}"</h2>
            <a href="{{ route('stories.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                Bersihkan Pencarian
            </a>
        </div>
        @else
        <h2 class="text-2xl font-bold text-gray-900">Temukan Cerita</h2>
        @endif
    </div>

    <!-- Stories Grid -->
    @if($stories->isEmpty())
    <div class="bg-white rounded-xl shadow-md overflow-hidden text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada cerita</h3>
        <p class="mt-1 text-gray-500">Coba genre lain atau cek lagi nanti ya</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($stories as $story)
            @include('components.story-card', ['story' => $story, 'showAuthor' => true])
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $stories->links() }}
    </div>
    @endif
</div>
@endsection