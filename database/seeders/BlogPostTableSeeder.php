<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogCount = $this->command->ask('How many blog posts would you like?',4);
        $users = \App\Models\User::all();

        \App\Models\BlogPost::factory($blogCount)->make()->each(function($posts) use ($users) {
            $posts->user_id = $users -> random()->id;
            $posts->save();
        });
    }
}
