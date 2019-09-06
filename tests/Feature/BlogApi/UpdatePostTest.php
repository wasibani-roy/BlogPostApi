<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanEditAPost()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $this->editPost = [
            'title' => 'test post',
            'body' => 'test post',
        ];
        
        $this->put('/api/post/'.$post->id, $this->editPost, $headers)->assertStatus(200);
    }

    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCannotEditPostTheyDidnotCreate()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $user2 = factory(User::class)->create();
        
        $token = $user2->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $this->editPost = [
            'title' => 'test post',
            'body' => 'test post',
        ];
        
        $this->put('/api/post/'.$post->id, $this->editPost, $headers)->assertStatus(401);
    }
}
