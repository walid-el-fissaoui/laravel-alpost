<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Collect(['Travel', 'Sport', 'Books', 'Sience', 'News', 'Games', 'Cars', 'Technology']);
        $tags->each(function ($tag) {
            $newTag = new Tag();
            $newTag->name = $tag;
            $newTag->save();
        });
    }
}
