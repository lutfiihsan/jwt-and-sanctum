## Tentang Project

Project ini dibangun dengan laravel 9 dan beberapa package tambahan seperti:

- Database: MySQL
- [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)

## Step Instalasi

1. Clone project ini dengan `git clone https://github.com/lutfiihsan/jwt-and-sanctum.git`
2. Jalankan `composer install`
3. Copy file `.env.example` menjadi `.env`
4. Jalankan `database:create nama_database` untuk membuat database
5. Konfiguari Laravel Sanctum : 
- Install Laravel Sanctum dengan menjalankan `composer require laravel/sanctum`
- Jalankan `php artisan migrate`
- Jalankan `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- Modifikasi `config/cors.php` pada bagian `credentials` menjadi `true`
- Tambahkan konfigurasi .env untuk Sanctum
```
SANCTUM_STATEFUL_DOMAINS=yourdomain.com
SANCTUM_STATEFUL_DOMAINS=localhost:8000
```
- Setelah itu, buka file app/Http/Kernel.php. Pada bagian $middlewareGroups, tambahkan middleware group api:sanctum sebagai berikut:
```
'api:sanctum' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ],
```
6. Konfigurasi JWT-Auth
'jwt' => [
            'driver' => 'jwt',
            'provider' => 'tokens',
        ], 
```

