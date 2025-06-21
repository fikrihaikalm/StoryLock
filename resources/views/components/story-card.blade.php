<div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
    <!-- Cover Image -->
    <div class="h-48 relative overflow-hidden">
        <img src="{{ $story->cover_image ? asset('storage/'.$story->cover_image) : 'https://source.unsplash.com/random/600x400?book,novel' }}" 
             alt="{{ $story->judul }}" 
             class="w-full h-full object-cover transition duration-500 hover:scale-105">
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
            <span class="inline-block px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-full">{{ $story->genre }}</span>
        </div>
    </div>
    
    <!-- Story Details -->
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">{{ $story->judul }}</h3>
        
        @if(isset($showAuthor) && $showAuthor)
        <div class="flex items-center mb-3">
            <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" 
                     src="https://ui-avatars.com/api/?name={{ urlencode($story->author->nama_lengkap) }}&background=indigo&color=white" 
                     alt="{{ $story->author->nama_lengkap }}">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ $story->author->nama_lengkap }}</p>
            </div>
        </div>
        @endif
        
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $story->deskripsi }}</p>
        
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">{{ $story->chapters_count }} chapters</span>
            <a href="{{ route('stories.show', $story->slug) }}" 
               class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                Baca
            </a>
        </div>
    </div>
</div>