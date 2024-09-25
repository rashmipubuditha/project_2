<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class Commentcontroller extends Controller
{
    //
    public function store(Request $request, $postId)
    {
        // Validate the incoming request data
        $request->validate([
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id', // You can also retrieve user_id from Auth if needed
        ]);

        // Check if the post exists
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        // Create the comment
        $comment = Comment::create([
            'body' => $request->body,
            'post_id' => $post->id, // Use the existing post ID
            'user_id' => $request->user_id, // Use user_id from the request
        ]);

        return response()->json($comment, 201);
    }

    // Update an existing comment
    public function update(Request $request, $commentId)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);
        
        // Find the comment
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
        
        // Update the comment with validated data
        $comment->update($validatedData);
        
        // Return a JSON response with the updated comment data
        return response()->json([
            'message' => 'Comment updated successfully!',
            'comment' => $comment,
        ], 200);
    }

    // Delete a comment
    public function destroy($commentId)
    {
        // Find the comment
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found.'], 404);
        }

        // Delete the comment
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
