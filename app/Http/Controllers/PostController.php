<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of posts.
     */
    public function index(Request $request): JsonResponse
    {
        if(!$this->hasPermission('list post')) throw new UnauthorizedException();

        $filters = $request->only(['user_id']);
        $posts = $this->postService->getAllPosts($filters);
        return response()->json($posts);
    }

    /**
     * Store a newly created post.
     */
    public function store(PostRequest $request): JsonResponse
    {
        if(!$this->hasPermission('create post')) throw new UnauthorizedException();
        $post = $this->postService->createPost($request->validated(),Auth::id());
        return response()->json($post, 201);
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post): JsonResponse
    {
        if(!$this->hasPermission('show post')) throw new UnauthorizedException();
        $post = $this->postService->getPostById($post->id);
        return response()->json($post);
    }

    /**
     * Update the specified post.
     */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        if(!$this->hasPermission('update post')) throw new UnauthorizedException();
        $post = $this->postService->updatePost($post->id, $request->validated());
        return response()->json($post);
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post): JsonResponse
    {
        if(!$this->hasPermission('delete post')) throw new UnauthorizedException();
        $this->postService->deletePost($post);
        return response()->json(['message' => 'Post deleted successfully']);
    }

    /**
     * approve post 
     */
    public function approvePost($id): JsonResponse
    {
        if(!$this->hasPermission('approve post')) throw new UnauthorizedException();
        $this->postService->approvePost($id);
        return response()->json(['message' => 'approved']);
    }

    /**
     * approve post 
     */
    public function rejectPost($id): JsonResponse
    {
        if(!$this->hasPermission('reject post')) throw new UnauthorizedException();
        $this->postService->rejectPost($id);
        return response()->json(['message' => 'rejected']);
    }

     /**
     * add comment to a post.
     */
    public function addComment(Request $request,Post $post): JsonResponse
    {
        $data = $request->only(['content']);

        $this->postService->addComment($data,$post,Auth::id());

        return response()->json(['message' => 'Comment added successfully!']);


    }
}
