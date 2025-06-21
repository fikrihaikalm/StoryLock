@extends('layouts.app')

@section('title', 'Add New Chapter')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Add New Chapter</h1>
                <p class="mt-1 text-sm text-gray-600">for <a href="{{ route('stories.show', $story->slug) }}" class="text-indigo-600 hover:underline">{{ $story->judul }}</a></p>
            </div>
            
            <form method="POST" action="{{ route('chapters.store', $story->id) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Chapter Title -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Chapter Title</label>
                        <input type="text" id="judul" name="judul" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- Illustration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Illustration (optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center" id="upload-container">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24" id="upload-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <img id="image-preview" class="hidden mx-auto max-h-48 rounded-md" />
                                <div class="flex text-sm text-gray-600" id="upload-text">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input type="file" name="gambar_pendukung" id="image-upload" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div>
                        <label for="isi" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="isi" name="isi" rows="15" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-serif text-lg leading-relaxed"></textarea>
                    </div>
                    
                    <!-- Word Counter -->
                    <div class="flex justify-end">
                        <div class="text-sm text-gray-500">
                            <span id="word-count">0</span> words
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('stories.show', $story->slug) }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Publish Chapter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Word counter
    document.getElementById('isi').addEventListener('input', function() {
        const content = this.value.trim();
        const wordCount = content === '' ? 0 : content.split(/\s+/).length;
        document.getElementById('word-count').textContent = wordCount;
    });

    // Image preview
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');
    const uploadIcon = document.getElementById('upload-icon');
    const uploadText = document.getElementById('upload-text');

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.classList.remove('hidden');
                uploadIcon.classList.add('hidden');
                uploadText.classList.add('hidden');
            }
            
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
            uploadIcon.classList.remove('hidden');
            uploadText.classList.remove('hidden');
            imagePreview.src = '';
        }
    });

    // Drag and drop functionality
    const uploadContainer = document.getElementById('upload-container');
    
    uploadContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadContainer.classList.add('border-indigo-500', 'bg-indigo-50');
    });

    uploadContainer.addEventListener('dragleave', () => {
        uploadContainer.classList.remove('border-indigo-500', 'bg-indigo-50');
    });

    uploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadContainer.classList.remove('border-indigo-500', 'bg-indigo-50');
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.match('image.*')) {
            imageUpload.files = e.dataTransfer.files;
            
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.classList.remove('hidden');
                uploadIcon.classList.add('hidden');
                uploadText.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection