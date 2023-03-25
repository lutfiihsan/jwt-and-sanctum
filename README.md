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
5. Install Laravel Sanctum dengan menjalankan `composer require laravel/sanctum`
6. Jalankan `php artisan migrate`
7. Install package jwt-auth dengan menjalankan `composer require php-open-source-saver/jwt-auth`

