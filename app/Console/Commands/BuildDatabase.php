<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BuildDatabase extends Command
{
    protected $signature = 'database:create {name?}';
    protected $description = 'Create a new MySQL database';

    public function handle()
    {
        $databaseName = $this->argument('name') ?? env('DB_DATABASE');

        if (!$databaseName) {
            return $this->error('Database name not specified.');
        }

        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        // create database query
        config(['database.connections.mysql.database' => null]);
        $query = "CREATE DATABASE IF NOT EXISTS {$databaseName} CHARACTER SET {$charset} COLLATE {$collation};";

        try {
            DB::statement($query);
            $this->info("Database '{$databaseName}' created successfully.");

            // update .env file with new database name
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str = str_replace('DB_DATABASE='.env('DB_DATABASE'), 'DB_DATABASE='.$databaseName, $str);
            file_put_contents($envFile, $str);

        } catch (\Exception $e) {
            $this->error('Error creating database: '.$e->getMessage());
        }
    }
}
