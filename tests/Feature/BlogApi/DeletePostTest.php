<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanDeleteAPost()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        
        $this->json('DELETE', '/api/post/' . $post->id, [], $headers)
            ->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCannotDeleteAnotherPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $user2 = factory(User::class)->create();
        
        $token = $user2->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        
        $this->json('DELETE', '/api/post/' . $post->id, [], $headers)
            ->assertStatus(401);
    }
}
