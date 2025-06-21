<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [StoryController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth.custom')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Story
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{slug}', [StoryController::class, 'show'])->name('stories.show');
    Route::get('/stories/{id}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{id}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');
    
    // Chapter
    Route::get('/stories/{story_id}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('/stories/{story_id}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('/stories/{story_slug}/chapter/{chapter_slug}', [ChapterController::class, 'show'])->name('chapters.show');
    Route::get('/stories/{story_id}/chapters/{chapter_id}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('/stories/{story_id}/chapters/{chapter_id}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/stories/{story_id}/chapters/{chapter_id}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
});