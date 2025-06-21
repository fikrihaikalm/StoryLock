<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoryLockSeeder extends Seeder
{
    public function run()
    {
        // Buat user fiktif
        $user1 = User::create([
            'username' => 'haikal',
            'nama_lengkap' => 'Muhammad Fikri Haikal',
            'password' => Hash::make('haikal123')
        ]);

        $user2 = User::create([
            'username' => 'lidia',
            'nama_lengkap' => 'Lidia',
            'password' => Hash::make('password')
        ]);

        // Cerita 1
        $story1 = Story::create([
            'judul' => 'Langit Senja di Ujung Desa',
            'slug' => Str::slug('Langit Senja di Ujung Desa'),
            'genre' => 'Romantis',
            'cover_image' => null,
            'deskripsi' => 'Sebuah kisah cinta remaja yang tumbuh di tengah hamparan sawah dan langit senja.',
            'created_by' => $user1->id
        ]);

        Chapter::create([
            'story_id' => $story1->id,
            'judul' => 'Bab 1: Perjumpaan Pertama',
            'slug' => 'bab-1-perjumpaan-pertama',
            'isi' => "Senja itu, langit memerah seolah ikut merasakan detak jantungku yang tak menentu. Di ujung desa, di bawah pohon jati tua, aku melihatnya untuk pertama kalinya. Rambutnya ditiup angin, matanya menatap langit, dan aku hanya bisa berdiri terpaku.\n\nNamanya Dinda. Dan sejak saat itu, namanya tidak pernah lagi keluar dari pikiranku.",
            'gambar_pendukung' => null
        ]);

        Chapter::create([
            'story_id' => $story1->id,
            'judul' => 'Bab 2: Hujan Pertama',
            'slug' => 'bab-2-hujan-pertama',
            'isi' => "Hujan turun deras. Aku dan Dinda berteduh di warung kecil pinggir sawah. Suasana hening, hanya suara rintik dan degup jantungku yang terasa terlalu keras.\n\n'Aku suka hujan,' katanya pelan. 'Karena hujan bisa menyembunyikan air mata.'\n\nAku tak tahu harus menjawab apa. Tapi di dalam hati, aku ingin jadi alasan dia tidak menangis lagi.",
            'gambar_pendukung' => null
        ]);

        // Cerita 2
        $story2 = Story::create([
            'judul' => 'Misteri Pasar Malam',
            'slug' => Str::slug('Misteri Pasar Malam'),
            'genre' => 'Horor',
            'cover_image' => null,
            'deskripsi' => 'Pasar malam yang hanya muncul sekali setahun, membawa misteri dan rahasia yang tak pernah terungkap.',
            'created_by' => $user2->id
        ]);

        Chapter::create([
            'story_id' => $story2->id,
            'judul' => 'Bab 1: Suara dari Tenda Kosong',
            'slug' => 'bab-1-suara-dari-tenda-kosong',
            'isi' => "Pasar malam itu datang tanpa pemberitahuan. Hanya selebaran misterius di tiang listrik. Kami datang karena penasaran, tapi suasananya aneh—sunyi di antara keramaian.\n\nAku mendekati tenda ramalan. Tidak ada orang di dalam, tapi aku mendengar suara. Suara yang memanggil namaku, pelan dan seram, dari balik tirai gelap.",
            'gambar_pendukung' => null
        ]);

        Chapter::create([
            'story_id' => $story2->id,
            'judul' => 'Bab 2: Boneka Tanpa Mata',
            'slug' => 'bab-2-boneka-tanpa-mata',
            'isi' => "Aku menang lotre boneka besar. Penjaganya tersenyum aneh dan berkata, 'Bawa pulang, jangan dibuang.'\n\nSaat aku sampai rumah, bonekanya tiba-tiba berpaling. Matanya kosong—karena memang tidak punya bola mata. Tapi malam itu, aku merasa dia melihatku. Dan tersenyum.",
            'gambar_pendukung' => null
        ]);
    }
}
