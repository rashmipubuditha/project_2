<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Postcontroller extends Controller
{
     /**
     * Display a paginated list of published posts.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $posts = Post::where('status', 'published')->with('user', 'comments')->paginate(10);
        return response()->json($posts);
    }

    /**
     * Store a new post.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'user_id' => 'required|exists:users,id',
        ]);
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'user_id' => $request->user_id, // Use user_id from the request
        ]);
    
        return response()->json($post, 201);
    }
    
    /**
     * Update an existing post.
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(Request $request, Post $id)
    {
       // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        // Update the post with validated data
        $id->update($validatedData);

        // Return a JSON response with the updated post data
        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => $id
        ], 200);
    }

     /**
     * Delete an existing post.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $id)
    {
         // Delete the post directly without authorization check
        $id->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
