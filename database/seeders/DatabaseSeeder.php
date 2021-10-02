<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm('do you want to refresh the database ?')) {
            /** to be yes by default */
        // if($this->command->confirm('do you want to refresh the database ?' , true)) { 
            $this->command->call("migrate:refresh");
            $this->command->info("database was refreshed !");
        }

        // \App\Models\User::factory(10)->create();
        // $this->call(UsersTableSeeder::class); /** call just one seeder */
        $this->call([
            UsersTableSeeder::class ,
            PostsTableSeeder::class ,
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            PostTagTableSeeder::class
        ]);
    }
}
