@extends($layout)
@section('title', 'Tentang Kami - StoryLock')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-indigo-800 mb-4">Tentang StoryLock</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Platform berbagi cerita digital yang menghubungkan pembaca dan penulis dari seluruh dunia.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h2>
            <p class="text-gray-700 mb-6">
                Menciptakan ekosistem literasi digital yang inklusif, dimana setiap orang dapat berbagi cerita mereka dan menemukan inspirasi dari karya orang lain.
            </p>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Menyediakan platform yang aman dan nyaman untuk berbagi cerita</li>
                <li>Mendorong kreativitas dan ekspresi diri melalui tulisan</li>
                <li>Membangun komunitas pembaca dan penulis yang saling mendukung</li>
                <li>Melestarikan cerita-cerita lokal dan tradisional dalam format digital</li>
            </ul>
        </div>
    </div>

    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Tim Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <img class="h-32 w-32 rounded-full mx-auto mb-4" src="{{ $member['photo'] }}" alt="{{ $member['name'] }}">
                    <h3 class="text-xl font-bold text-center text-gray-900">{{ $member['name'] }}</h3>
                    <p class="text-indigo-600 text-center mb-2">{{ $member['role'] }}</p>
                    <p class="text-gray-600 text-center">{{ $member['bio'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-indigo-50 rounded-xl p-8">
        <h2 class="text-2xl font-bold text-center text-indigo-800 mb-6">Bergabunglah Dengan Komunitas Kami</h2>
        <p class="text-gray-700 text-center mb-6 max-w-2xl mx-auto">
            Mulai berbagi ceritamu hari ini atau temukan inspirasi dari karya penulis lainnya.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                Daftar Sekarang
            </a>
            <a href="{{ route('stories.index') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                Jelajahi Cerita
            </a>
        </div>
    </div>
</div>
@endsection