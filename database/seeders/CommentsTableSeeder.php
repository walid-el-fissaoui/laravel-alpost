<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
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
        $posts = Post::all();
        $users = User::all();

        if($posts->count() == 0)
        {
            $this->command->info("there is no posts , please create someone !");
            return;
        }

        $nbComments = (int)$this->command->ask("how many comment you want to generate ?" , 100);
   
        Comment::factory($nbComments)->make()->each(function($comment) use($posts,$users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Models\Post';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory($nbComments)->make()->each(function($comment) use($users){
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\Models\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
