<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    // public function show($story_slug, $chapter_slug)
    // {
    //     if (!Session::has('user_id')) {
    //         return redirect()->route('login');
    //     }

    //     $story = Story::where('slug', $story_slug)->firstOrFail();
    //     $chapter = Chapter::where('story_id', $story->id)
    //                     ->where('slug', $chapter_slug)
    //                     ->firstOrFail();

    //     return view('chapters.show', [
    //         'story' => $story,
    //         'chapter' => $chapter,
    //         'isOwner' => $story->created_by == Session::get('user_id'),
    //     ]);
    // }

    public function show($story_slug, $chapter_slug)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('slug', $story_slug)->firstOrFail();

        $chapter = Chapter::where('story_id', $story->id)
                        ->where('slug', $chapter_slug)
                        ->firstOrFail();

        // Cari chapter sebelumnya
        $previousChapter = Chapter::where('story_id', $story->id)
                                ->where('id', '<', $chapter->id)
                                ->orderBy('id', 'desc')
                                ->first();

        // Cari chapter setelahnya
        $nextChapter = Chapter::where('story_id', $story->id)
                            ->where('id', '>', $chapter->id)
                            ->orderBy('id', 'asc')
                            ->first();

        return view('chapters.show', [
            'story' => $story,
            'chapter' => $chapter,
            'isOwner' => $story->created_by == Session::get('user_id'),
            'previousChapter' => $previousChapter,
            'nextChapter' => $nextChapter,
        ]);
    }


    public function create($story_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($story_id);

        return view('chapters.create', [
            'story' => $story,
        ]);
    }

    public function store(Request $request, $story_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($story_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar_pendukung')) {
            $imagePath = $request->file('gambar_pendukung')->store('chapter_images', 'public');
        }

        Chapter::create([
            'story_id' => $story_id,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'gambar_pendukung' => $imagePath,
        ]);

        return redirect()->route('stories.show', ['slug' => $story->slug])
                        ->with('success', 'Chapter berhasil ditambahkan!');
    }

    public function edit($story_id, $chapter_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($story_id);
        $chapter = Chapter::where('story_id', $story_id)
                        ->findOrFail($chapter_id);

        return view('chapters.edit', [
            'story' => $story,
            'chapter' => $chapter,
        ]);
    }

    public function update(Request $request, $story_id, $chapter_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($story_id);
        $chapter = Chapter::where('story_id', $story_id)
                        ->findOrFail($chapter_id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar_pendukung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $chapter->gambar_pendukung;
        if ($request->hasFile('gambar_pendukung')) {
            // Delete old image if exists
            if ($chapter->gambar_pendukung) {
                Storage::delete('public/' . $chapter->gambar_pendukung);
            }
            $imagePath = $request->file('gambar_pendukung')->store('chapter_images', 'public');
        }

        $chapter->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'gambar_pendukung' => $imagePath,
        ]);

        return redirect()->route('chapters.show', [
            'story_slug' => $story->slug,
            'chapter_slug' => $chapter->slug
        ])->with('success', 'Chapter berhasil diperbarui!');
    }

    public function destroy($story_id, $chapter_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        $story = Story::where('created_by', Session::get('user_id'))
                    ->findOrFail($story_id);
        $chapter = Chapter::where('story_id', $story_id)
                        ->findOrFail($chapter_id);

        // Delete image if exists
        if ($chapter->gambar_pendukung) {
            Storage::delete('public/' . $chapter->gambar_pendukung);
        }

        $chapter->delete();

        return redirect()->route('stories.show', ['slug' => $story->slug])
                        ->with('success', 'Chapter berhasil dihapus!');
    }
}