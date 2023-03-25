## Tentang Project

Project ini dibangun dengan laravel 9 dan beberapa package tambahan seperti:

- Database: MySQL
- [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)
- [PHP-Open-Source-Saver/jwt-auth](https://github.com/PHP-Open-Source-Saver/jwt-auth)

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
- Setelah itu, buka file app/Http/Kernel.php. Pada bagian $middlewareGroups, tambahkan middleware group api:sanctum sebagai berikut:
```
'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ],
```
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
- Install package jwt-auth dengan menjalankan `composer require php-open-source-saver/jwt-auth`
- Jalankan `php artisan jwt:secret`
- Modifikasi `config/auth.php` pada bagian `guards` menjadi seperti berikut:
```
'jwt' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ], 
```
- Terakhir, tambahkan middleware group jwt.verify pada file app/Http/Kernel.php seperti ini:
```
'jwt.verify' => [
   \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
],
```

