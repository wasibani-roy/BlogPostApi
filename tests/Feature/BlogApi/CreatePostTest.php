<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanCreatePost()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $this->post = [
            'title' => 'test post',
            'body' => 'test post',
        ];
        
        $this->post('/api/post', $this->post, $headers)->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanCreatePostjson()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->post = [
            'title' => 'test post',
            'body' => 'test post',
        ];
        $this->posts = [
            'data' => [
                'id' => 1,
                'title' => 'test post',
                'body' => 'test post',
                'user' => [
                    'author_name' => $user->name,
                    'author_email' => $user->email
                ]
            ],
        ];
        $this->post('/api/post', $this->post, $headers)->assertJson($this->posts);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnauthenticatedUserCanNotCreatePost()
    {
        $this->post = [
            'title' => 'test post',
            'body' => 'test post',
        ];
        
        $this->post('/api/post', $this->post)->assertStatus(401);
    }
}
