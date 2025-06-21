<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    // public function index()
    // {
    //     $genre = request('genre');
        
    //     $query = Story::with(['author', 'chapters'])
    //                 ->withCount('chapters')
    //                 ->latest();

    //     if ($genre) {
    //         $query->where('genre', $genre);
    //     }

    //     // Tambahkan paginate() bukan get()
    //     $stories = $query->paginate(12); // 12 item per halaman

    //     return view('stories.index', [
    //         'stories' => $stories,
    //         'isAuthenticated' => session()->has('user_id')
    //     ]);
    // }

    public function index()
    {
        if (!session()->has('user_id')) {
            $featuredStories = Story::withCount('chapters')->latest()->take(6)->get();

            return view('welcome', [
                'stories' => $featuredStories
            ]);
        }

        // Jika sudah login
        $genre = request('genre');
        $search = request('search');


        $query = Story::with(['author', 'chapters'])
                    ->withCount('chapters')
                    ->latest();

        if ($genre) {
            $query->where('genre', $genre);
        }

        // $stories = $query->paginate(12);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%'.$search.'%')
                ->orWhere('deskripsi', 'like', '%'.$search.'%')
                ->orWhereHas('author', function($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%'.$search.'%');
                });
            });
        }

        $stories = $query->paginate(12);


        return view('stories.index', [
            'stories' => $stories,
            'isAuthenticated' => true
        ]);
    }

    public function show($slug)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::with(['chapters', 'author'])
                    ->where('slug', $slug)
                    ->firstOrFail();

        return view('stories.show', [
            'story' => $story,
            'isOwner' => $story->created_by == Session::get('user_id'),
        ]);
    }

    public function create()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        return view('stories.create');
    }

    public function store(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('story_covers', 'public');
        }

        Story::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'genre' => $request->genre,
            'cover_image' => $coverPath,
            'deskripsi' => $request->deskripsi,
            'created_by' => Session::get('user_id'),
        ]);

        return redirect()->route('profile')
                        ->with('success', 'Cerita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($id);

        return view('stories.edit', [
            'story' => $story,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $coverPath = $story->cover_image;
        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($story->cover_image) {
                Storage::delete('public/' . $story->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('story_covers', 'public');
        }

        $story->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'genre' => $request->genre,
            'cover_image' => $coverPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('stories.show', ['slug' => $story->slug])
                        ->with('success', 'Cerita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($id);

        // Delete cover image if exists
        if ($story->cover_image) {
            Storage::delete('public/' . $story->cover_image);
        }

        $story->delete();

        return redirect()->route('profile')
                        ->with('success', 'Cerita berhasil dihapus!');
    }
}