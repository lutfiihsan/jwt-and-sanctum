## Tentang Project

Project ini dibangun dengan laravel 9 dan beberapa package tambahan seperti:

- Database: MySQL
- [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)
- JWT-Auth Custom

Dimana sanctum digunakan untuk autentikasi dan JWT-Auth digunakan untuk mengakses api public.

## Step Instalasi

1. Clone project ini dengan `git clone https://github.com/lutfiihsan/jwt-and-sanctum.git`
2. Jalankan `composer install`
3. Copy file `.env.example` menjadi `.env` dan tambahkan ini :
```
JWT_SECRET=8cQ0sN8CyeE0tGhF7EUaz8DcKtfG01CtrcV5lplKUVrrasIIs2PzFCq1tVzqOQOZ

JWT_DOMAIN=abc.com

JWT_ALGO=HS256

API_KEY=123
``

4. Jalankan `database:create nama_database` untuk membuat database
5. Konfiguari Laravel Sanctum : 
- Install Laravel Sanctum dengan menjalankan `composer require laravel/sanctum`
- Jalankan `php artisan migrate`
- Jalankan `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- Setelah itu, buka file app/Http/Kernel.php. Pada bagian $middlewareGroups, tambahkan middleware group api:sanctum sebagai berikut:
```
'api:sanctum' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ],
```
6. Konfigurasi JWT-Auth
```
'jwt' => [
            'driver' => 'jwt',
            'provider' => 'tokens',
        ], 
```

## Step cara penggunaan

1. Jalankan `php artisan serve`
2. Register user baru dengan mengakses `http://localhost:8000/api/register` dengan method POST dan body sebagai berikut:
```
{
    "name": "demo",
    "email": "demo@gmail.com",
    "password": "demo123",
}
```
3. Lalu pilih authorization type `api_key`, masukkan `key => client-secret` dan `value => xxxxx`
4. Login dengan mengakses `http://localhost:8000/api/login`
5. Untuk melihat profile, silahkan akses `http://localhost:8000/api/user` dan masukkan token yang didapatkan saat login/register
6. Untuk mendapatkan `client-secret`, akses `http://localhost:8000/api/token` dengan method POST dan body sebagai berikut :
```
{
    'api_key' => dari env
    'domain' => domain.com
} 
```
