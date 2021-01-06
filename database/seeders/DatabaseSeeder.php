<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // static method
        // DB::table('users')->insert([
        //     'name' => 'John Doe',
        //     'email' => 'john@laravel.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        if($this->command->confirm('Do you want to refresh the database?')) {
            $this ->command->call('migrate:fresh');
            $this ->command->info('Data base was refreshed');

        }

        Cache::tags(['blog-post'])->flush();

        $this->call([
            UsersTableSeeder::class,
            BlogPostTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
