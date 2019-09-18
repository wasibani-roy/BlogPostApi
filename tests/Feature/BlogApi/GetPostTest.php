<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetPostTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanGetPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $this->get('/api/post/'. $post->id)->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostDoesnotExist()
    {
        $this->get('/api/post/3')->assertStatus(404);
    }

    
}
