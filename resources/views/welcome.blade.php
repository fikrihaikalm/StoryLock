@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            Temukan dan Bagikan Kisah-Kisah Menakjubkan
        </h1>
        <p class="max-w-2xl mx-auto text-xl text-gray-600">
            Bergabunglah dengan komunitas pembaca dan penulis kami. Ciptakan kisah Anda sendiri atau jelajahi ribuan kisah lainnya.
        </p>
        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('register') }}" class="px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                Mulai Sekarang
            </a>
            <a href="{{ route('login') }}" class="px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                Masuk
            </a>
        </div>
    </div>

    <!-- Featured Stories -->
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Sorotan Kisah</h2>
        @if($stories->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <p class="text-gray-500">No stories available yet. Be the first to create one!</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($stories as $story)
                @include('components.story-card', ['story' => $story, 'showAuthor' => true])
            @endforeach
        </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="bg-indigo-700 rounded-xl shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 lg:py-16">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        Siap untuk memulai cerita pribadimu?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg leading-6 text-indigo-200">
                        Gabung bersama ribuan penulis lain yang berbagi kisah mereka ke seluruh dunia.
                    </p>
                </div>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0 lg:justify-end">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Daftar Sekarang Gratis!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection