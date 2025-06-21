@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-md mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Edit Profil</h2>
            </div>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                
                <div class="space-y-6">
                    <!-- Profile Picture -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <img class="h-24 w-24 rounded-full" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=indigo&color=white&size=128&length=1" 
                                alt="{{ $user->nama_lengkap }}">
                        </div>
                    </div>
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- Full Name -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('profile') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection