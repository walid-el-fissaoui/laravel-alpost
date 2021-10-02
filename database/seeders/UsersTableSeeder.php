<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbUsers =  (int)$this->command->ask("how many user you want to generate ?" , 10); /**generate 10 users by defaukt*/
        User::factory($nbUsers)->create();
    }
}
