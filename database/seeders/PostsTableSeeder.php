<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if($users->count() == 0)
        {
            $this->command->info("there is no users , please create someone !");
            return;
        }

        $nbPosts = (int)$this->command->ask("how many post you want to generate ?" , 50);
         Post::factory($nbPosts)->make()->each(function($post) use($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
