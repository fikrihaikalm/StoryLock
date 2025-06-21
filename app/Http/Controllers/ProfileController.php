<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::withCount(['stories as chapters_count' => function($query) {
            $query->join('chapters', 'stories.id', '=', 'chapters.story_id')
                  ->selectRaw('count(chapters.id)');
        }])->findOrFail(Session::get('user_id'));

        $stories = $user->stories()->withCount('chapters')->latest()->get();

        return view('profile.show', [
            'user' => $user,
            'stories' => $stories
        ]);
    }

    public function edit()
    {
        $user = User::findOrFail(Session::get('user_id'));
        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Session::get('user_id'));

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $user->update([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
        ]);

        // Update session data
        Session::put('username', $user->username);
        Session::put('nama_lengkap', $user->nama_lengkap);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}