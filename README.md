# 📚 StoryLock

**StoryLock** adalah aplikasi web berbagi cerita yang dibangun dengan Laravel. Aplikasi ini menerapkan sistem autentikasi, otorisasi, session management, dan cookies untuk memberikan pengalaman pengguna yang aman dan personal.

## 🎯 Fitur Utama

### 🔐 Sistem Autentikasi & Otorisasi
- **Registrasi Pengguna**: Pendaftaran akun baru dengan validasi
- **Login/Logout**: Sistem masuk dan keluar yang aman
- **Session Management**: Pengelolaan sesi pengguna menggunakan Laravel Session
- **Custom Authentication Middleware**: Middleware khusus untuk proteksi route
- **Authorization**: Kontrol akses berdasarkan kepemilikan konten

### 📖 Manajemen Cerita
- **CRUD Cerita**: Buat, baca, edit, dan hapus cerita
- **Sistem Chapter**: Setiap cerita dapat memiliki multiple chapter
- **Genre Kategorisasi**: Pengelompokan cerita berdasarkan genre
- **Cover Image**: Upload gambar cover untuk cerita
- **Slug System**: URL-friendly untuk setiap cerita

### 🔍 Fitur Pencarian & Filter
- **Pencarian**: Cari cerita berdasarkan judul, deskripsi, atau nama penulis
- **Filter Genre**: Filter cerita berdasarkan kategori genre
- **Pagination**: Navigasi halaman yang efisien

### 👤 Profil Pengguna
- **Dashboard Profil**: Halaman profil personal
- **Edit Profil**: Update informasi pengguna
- **Manajemen Cerita**: Kelola cerita yang dimiliki

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 10
- **Database**: MySQL/SQLite
- **Frontend**: Blade Templates, Tailwind CSS
- **Authentication**: Custom Session-based Authentication
- **File Storage**: Laravel Storage (untuk cover images)

## 🔧 Implementasi Cookies, Session, Autentikasi & Otorisasi

### 1. Session Management
```php
// Konfigurasi session di config/session.php
'driver' => env('SESSION_DRIVER', 'file'),
'lifetime' => env('SESSION_LIFETIME', 120),
'cookie' => env('SESSION_COOKIE', 'storylock_session'),
'http_only' => true,
'same_site' => 'lax',
```

### 2. Custom Authentication
Aplikasi menggunakan custom authentication middleware:

```php
// app/Http/Middleware/AuthenticateCustom.php
public function handle(Request $request, Closure $next)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login');
    }
    return $next($request);
}
```

### 3. Session Storage
Data pengguna disimpan dalam session setelah login:
```php
// Login Controller
Session::put('user_id', $user->id);
Session::put('username', $user->username);
Session::put('nama_lengkap', $user->nama_lengkap);
```

### 4. Authorization
Kontrol akses berdasarkan kepemilikan:
```php
// Hanya pemilik yang dapat mengedit/hapus cerita
$story = Story::where('created_by', Session::get('user_id'))
            ->findOrFail($id);
```

### 5. Cookie Security
- **HTTP Only**: Cookies tidak dapat diakses via JavaScript
- **Same-Site**: Perlindungan CSRF dengan setting 'lax'
- **Encryption**: Cookies dienkripsi otomatis oleh Laravel

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/SQLite
- Web Server (Apache/Nginx)

## 🚀 Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd StoryLock
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=storylock
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Database Migration & Seeding**
```bash
php artisan migrate
php artisan db:seed --class=StoryLockSeeder
```

6. **Storage Link**
```bash
php artisan storage:link
```

7. **Build Assets**
```bash
npm run build
```

8. **Start Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👥 Akun Demo

Setelah menjalankan seeder, Anda dapat menggunakan akun berikut:

**Akun 1:**
- Username: `haikal`
- Password: `haikal123`

**Akun 2:**
- Username: `lidia`
- Password: `password`

## 🗂️ Struktur Proyek

```
StoryLock/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── StoryController.php
│   │   │   ├── ChapterController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       ├── AuthenticateCustom.php  # Custom auth middleware
│   │       └── EncryptCookies.php      # Cookie encryption
│   ├── Models/
│   │   ├── User.php
│   │   ├── Story.php
│   │   └── Chapter.php
│   └── Providers/
├── config/
│   ├── auth.php              # Authentication config
│   ├── session.php           # Session config
│   └── app.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/             # Login/Register views
│       ├── stories/          # Story management views
│       └── profile/          # Profile views
└── routes/
    └── web.php               # Route definitions
```

## 🛣️ Route Structure

### Public Routes
- `GET /` - Homepage (menampilkan featured stories untuk guest, full stories untuk authenticated users)
- `GET /about` - Halaman tentang aplikasi

### Authentication Routes
- `GET /login` - Form login
- `POST /login` - Proses login
- `GET /register` - Form registrasi
- `POST /register` - Proses registrasi
- `POST /logout` - Logout (authenticated only)

### Protected Routes (Memerlukan Authentication)
- `GET /profile` - Halaman profil pengguna
- `GET /profile/edit` - Form edit profil
- `PUT /profile` - Update profil

### Story Management (Authenticated Users)
- `GET /stories` - Daftar semua cerita
- `GET /stories/create` - Form buat cerita baru
- `POST /stories` - Simpan cerita baru
- `GET /stories/{slug}` - Detail cerita
- `GET /stories/{id}/edit` - Form edit cerita (owner only)
- `PUT /stories/{id}` - Update cerita (owner only)
- `DELETE /stories/{id}` - Hapus cerita (owner only)

### Chapter Management
- `GET /stories/{story}/chapters/create` - Form buat chapter baru
- `POST /stories/{story}/chapters` - Simpan chapter baru
- `GET /chapters/{id}` - Baca chapter
- `GET /chapters/{id}/edit` - Form edit chapter (owner only)
- `PUT /chapters/{id}` - Update chapter (owner only)
- `DELETE /chapters/{id}` - Hapus chapter (owner only)

## 🔒 Security Features

### 1. CSRF Protection
- Semua form dilindungi dengan CSRF token
- Middleware `VerifyCsrfToken` aktif untuk semua route web

### 2. Password Hashing
- Password di-hash menggunakan bcrypt
- Verifikasi password menggunakan `Hash::check()`

### 3. Session Security
- Session ID regeneration setelah login
- HTTP-only cookies untuk mencegah XSS
- Same-site cookie policy untuk CSRF protection

### 4. Input Validation
- Validasi input pada semua form
- Sanitasi data menggunakan Laravel validation rules

### 5. Authorization Checks
- Middleware custom untuk authentication
- Owner-based authorization untuk CRUD operations
- Route protection dengan middleware groups

## 📊 Database Schema

### Users Table
```sql
- id (Primary Key)
- username (Unique)
- nama_lengkap
- password (Hashed)
- created_at
- updated_at
```

### Stories Table
```sql
- id (Primary Key)
- judul
- slug (Unique)
- genre
- cover_image (Nullable)
- deskripsi
- created_by (Foreign Key to users.id)
- created_at
- updated_at
```

### Chapters Table
```sql
- id (Primary Key)
- story_id (Foreign Key to stories.id)
- judul
- konten
- nomor_chapter
- created_at
- updated_at
```

## 🎨 Frontend Features

### Responsive Design
- Mobile-first approach dengan Tailwind CSS
- Responsive navigation dan layout
- Optimized untuk berbagai ukuran layar

### User Experience
- Flash messages untuk feedback
- Loading states dan error handling
- Intuitive navigation dan breadcrumbs

### Image Handling
- Upload dan preview cover images
- Automatic image optimization
- Fallback untuk missing images

## 🧪 Testing

Untuk menjalankan tests:

```bash
# Unit Tests
php artisan test --testsuite=Unit

# Feature Tests
php artisan test --testsuite=Feature

# Semua Tests
php artisan test
```

## 📝 Development Notes

### Session Implementation
Aplikasi menggunakan file-based session storage dengan konfigurasi:
- Session lifetime: 120 menit
- Cookie name: `storylock_session`
- Encryption: Enabled
- HTTP Only: True

### Authentication Flow
1. User mengisi form login
2. Kredensial divalidasi terhadap database
3. Jika valid, data user disimpan dalam session
4. Session ID disimpan dalam encrypted cookie
5. Middleware memeriksa session pada setiap request

### Authorization Pattern
```php
// Contoh authorization check
if ($story->created_by !== Session::get('user_id')) {
    abort(403, 'Unauthorized action.');
}
```

## 🚀 Deployment

### Production Setup
1. Set environment ke production di `.env`
2. Optimize autoloader: `composer install --optimize-autoloader --no-dev`
3. Cache configuration: `php artisan config:cache`
4. Cache routes: `php artisan route:cache`
5. Cache views: `php artisan view:cache`

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=database  # Recommended for production
SESSION_SECURE_COOKIE=true  # For HTTPS
```

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Proyek ini menggunakan [MIT License](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Dikembangkan sebagai tugas implementasi Cookies, Session, Autentikasi, dan Otorisasi menggunakan Laravel.

---

**StoryLock** - Platform berbagi cerita dengan keamanan terdepan 🔐📚
