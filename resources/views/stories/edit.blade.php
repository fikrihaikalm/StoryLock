@extends('layouts.app')

@section('title', 'Edit Story')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Story</h1>
                <p class="mt-1 text-sm text-gray-600">Update your story details</p>
            </div>
            
            <form method="POST" action="{{ route('stories.update', $story->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Current Cover  -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Cover</label>
                        @if($story->cover_image)
                        <div class="mt-1">
                            <img src="{{ asset('storage/'.$story->cover_image) }}" 
                                 alt="Current cover" 
                                 class="h-40 rounded-md object-cover">
                        </div>
                        @else
                        <div class="mt-1 text-sm text-gray-500">No cover image</div>
                        @endif
                    </div>
                    

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Cover Image (optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input type="file" name="cover_image" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $story->judul) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                        <select id="genre" name="genre" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="Fantasy" {{ $story->genre === 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                            <option value="Romance" {{ $story->genre === 'Romance' ? 'selected' : '' }}>Romance</option>
                            <option value="Mystery" {{ $story->genre === 'Mystery' ? 'selected' : '' }}>Mystery</option>
                            <option value="Sci-Fi" {{ $story->genre === 'Sci-Fi' ? 'selected' : '' }}>Science Fiction</option>
                            <option value="Horror" {{ $story->genre === 'Horror' ? 'selected' : '' }}>Horror</option>
                        </select>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $story->deskripsi) }}</textarea>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('stories.show', $story->slug) }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Update Story
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection