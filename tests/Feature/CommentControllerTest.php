<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_a_comment_to_a_post()
    {
        $user = User::factory()->create(); // Create a user using the factory
        $post = Post::factory()->create(['user_id' => $user->id]); // Create a post for that user

        $response = $this->actingAs($user) // Authenticate the user
            ->post("/api/posts/{$post->id}/comments", [
                'body' => 'This is a comment.',
                'user_id' => $user->id, // Include user_id
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'body' => 'This is a comment.',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put("/api/comments/{$comment->id}", [
                'body' => 'Updated comment body.',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'body' => 'Updated comment body.',
        ]);
    }

    /** @test */
    public function it_can_delete_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/api/comments/{$comment->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /** @test */
    public function it_returns_error_when_comment_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put("/api/comments/9999", [
            'body' => 'Trying to update a non-existent comment.',
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Comment not found.']);
    }

    /** @test */
    public function it_returns_error_when_post_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/api/posts/9999/comments", [
            'body' => 'This is a comment.',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Post not found.']);
    }
}
