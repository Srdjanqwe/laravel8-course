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
        $users = \App\Models\User::all();


        if($posts->count() ===0 || $users->count() ===0) {
            $this ->command->info('There are no blog posts or users, so no comments will be added');
            return;

        }

        $commentsCount = $this->command->ask('How many comments would you like?',8);

        // $users = \App\Models\User::all();

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comments) use ($posts, $users) {

            $comments->commentable_id = $posts->random()->id;
            $comments->commentable_type = 'App\Models\BlogPost';
            $comments->user_id = $users->random()->id;
            $comments->save();

        });

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comments) use ($users) {

            $comments->commentable_id = $users->random()->id;
            $comments->commentable_type = 'App\Models\User';
            $comments->user_id = $users->random()->id;
            $comments->save();

        });

    }
}
