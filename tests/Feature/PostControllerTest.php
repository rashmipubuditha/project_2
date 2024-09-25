<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post()
    {
        $user = User::factory()->create(); // Assuming have a User factory

        $response = $this->actingAs($user)
            ->post('/api/posts', [
                'title' => 'Test Post',
                'content' => 'This is a test post content.',
                'status' => 'published',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
        ]);
    }

    /** @test */
    public function it_can_get_all_published_posts()
    {
        $user = User::factory()->create();
        Post::factory()->create(['status' => 'published', 'user_id' => $user->id]);

        $response = $this->get('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'content', 'status', 'user_id', 'created_at', 'updated_at'],
            ],
        ]);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put("/api/posts/{$post->id}", [
                'title' => 'Updated Title',
                'content' => 'Updated content.',
                'status' => 'draft',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', [
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
