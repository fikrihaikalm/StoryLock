<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index()
    {
        $layout = session()->has('user_id') ? 'layouts.app' : 'layouts.guest';

        return view('about.index', [
            'title' => 'Tentang Kami',
            'layout' => $layout,
            'teamMembers' => [
                [
                    'name' => 'Haikal',
                    'role' => 'Founder & CEO',
                    'bio' => 'Pendiri StoryLock dengan passion di dunia literasi digital.',
                    'photo' => 'kal.jpg'
                ],
                [
                    'name' => 'Lid',
                    'role' => 'Head of Content',
                    'bio' => 'Mengawasi kualitas konten dan pengalaman pengguna.',
                    'photo' => 'lid.jpg'
                ],
            ]
        ]);
    }
}