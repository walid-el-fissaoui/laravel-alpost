<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function testSavePost()
    {
        $post = new Post();
        $post->title = "new title";
        $post->content = "new content";
        $post->slug = Str::slug($post->title , '-');
        $post->active = false;
        $post->save();
        $this->assertDatabaseHas('posts',[
            'title' => 'new title'
        ]);
    }
    public function testPostStoreValide()
    {
        $data = [
            'title' => 'new title',
            'content' => 'new content',
            'slug' => Str::slug('new title','-'),
            'active' => false
        ];

        $this->post('/posts' , $data)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status') , 'post was created!!');
    }
    public function testPostStoreFail()
    {
        $data = [
            'title' => '',
            'content' => ''
        ];
        $this->post('/posts',$data)->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0] , "The title must be at least 4 characters.");
        $this->assertEquals($messages['content'][0] , "The content field is required.");
    }

    public function testPostUpdate()
    {
        $post = new Post();
        $post->title = 'new title';
        $post->content = 'new content';
        $post->slug = Str::slug('new title','-');
        $post->active = false;
        $post->save();
        $this->assertDatabaseHas('posts', $post->toArray());

        $data = [
            'title' => 'new title updated',
            'content' => 'new content updated',
            'slug' => Str::slug('new title updated','-'),
            'active' => false
        ];

        $this->put("/posts/{$post->id}",$data)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'post was updated');
        $this->assertDatabaseHas('posts',[
            'title' => $data['title']
        ]);
        $this->assertDatabaseMissing('posts',[
            'title' => $post->title
        ]);
    }

    public function testPostDelete()
    {
        $post = new Post();
        $post->title = 'new title';
        $post->content = 'new content';
        $post->slug = Str::slug('new title' , '-');
        $post->active = false;
        $post->save();
        $this->assertDatabaseHas('posts', $post->toArray());
        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'post was deleted !');
        $this->assertDatabaseMissing('posts',$post->toArray());
    }

}
