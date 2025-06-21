@extends('layouts.app')

@section('title', 'Create New Story')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Story</h1>
                <p class="mt-1 text-sm text-gray-600">Start your storytelling journey</p>
            </div>
            
            <form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Cover Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center" id="image-upload-container">
                                <!-- Preview Container -->
                                <div id="image-preview" class="hidden mb-4">
                                    <img id="preview-image" class="mx-auto h-48 rounded-md object-cover">
                                </div>
                                
                                <!-- Default Upload UI -->
                                <div id="default-upload-ui">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input type="file" name="cover_image" id="cover_image" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="judul" name="judul" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                        <select id="genre" name="genre" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a genre</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Romance">Romance</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Sci-Fi">Science Fiction</option>
                            <option value="Horror">Horror</option>
                        </select>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('profile') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Publish Story
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const coverImageInput = document.getElementById('cover_image');
        const imagePreview = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        const defaultUploadUI = document.getElementById('default-upload-ui');
        
        coverImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    defaultUploadUI.classList.add('hidden');
                }
                
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
                defaultUploadUI.classList.remove('hidden');
            }
        });
        
        // Handle drag and drop
        const uploadContainer = document.getElementById('image-upload-container');
        
        uploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadContainer.classList.add('border-indigo-500', 'bg-indigo-50');
        });
        
        uploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadContainer.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
        
        uploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadContainer.classList.remove('border-indigo-500', 'bg-indigo-50');
            
            if (e.dataTransfer.files.length) {
                coverImageInput.files = e.dataTransfer.files;
                const event = new Event('change');
                coverImageInput.dispatchEvent(event);
            }
        });
    });
</script>

<style>
    #image-upload-container {
        transition: all 0.2s ease;
    }
</style>
@endsection