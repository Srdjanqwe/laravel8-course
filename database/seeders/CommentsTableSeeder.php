<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Models\BlogPost::all();

        if($posts->count() ===0) {
            $this ->command->info('There are no blog posts, so no comments will be added');
            return;

        }

        $commentsCount = $this->command->ask('How many comments would you like?',8);

        $users = \App\Models\User::all();

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comments) use ($posts, $users) {

            $comments->blog_post_id = $posts->random()->id;
            $comments->user_id = $users->random()->id;
            $comments->save();

        });
    }
}
