<?php

namespace App\Services;

use App\Events\PostApproved;
use App\Models\Post;
use App\Models\Scopes\ScopeWithAtLeastXComments;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostService
{
    /**
     * Retrieve all posts with optional filters.
     */
    public function getAllPosts(array $filters = [])
    {
        $query = Post::query();

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->with(['user', 'comments', 'categories']);
    }

    /**
     * Retrieve a single post by ID.
     */
    public function getPostById(Post $post)
    {
        return $post->load(['user', 'comments', 'categories']);
    }

    /**
     * Create a new post.
     */
    public function createPost(array $data,int $userId)
    {
        return DB::transaction(function () use ($data,$userId) {
            $post = Post::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $userId,
            ]);

            if (isset($data['category_ids'])) {
                $post->categories()->attach($data['category_ids']);
            }

            return $post;
        });
    }

    /**
     * Update an existing post.
     */
    public function updatePost(Post $post, array $data)
    {
        return DB::transaction(function () use ($post, $data) {
            $post->update($data);

            if (isset($data['category_ids'])) {
                $post->categories()->sync($data['category_ids']);
            }

            return $post;
        });
    }

    /**
     * Delete a post.
     */
    public function deletePost(Post $post)
    {
        $post->delete();
        return true;
    }

    /**
     * approve a post.
     */
    public function approvePost(int $id)
    {

       $post = Post::withoutGlobalScope(ScopeWithAtLeastXComments::class)
            ->where('id',$id)->first();
        if($post ){
            if($post->status == Post::STATUS_DRAFT){
                $post->update(['status' => Post::STATUS_APPROVED]);
                event(new PostApproved($post));
            }
            else{
                throw ValidationException::withMessages([
                    'post' => ['post must be bending so you can approve'],
                ]); 
            }
        }else{
            throw ValidationException::withMessages([
                'post' => ['post not found !'],
            ]); 
        }
       return true;
    }

     /**
     * reject a post.
     */
    public function rejectPost(int $id)
    {
        $post = Post::withoutGlobalScope(ScopeWithAtLeastXComments::class)
            ->where('id',$id)->first();
        if($post ){
            if($post->status == Post::STATUS_DRAFT){
                $post->update(['status' => Post::STATUS_REJECTED]);
            }
            else{
                throw ValidationException::withMessages([
                    'post' => ['post must be bending so you can rejected'],
                ]); 
            }
        }else{
            throw ValidationException::withMessages([
                'post' => ['post not found !'],
            ]); 
        }
       return true;
    }

     /**
     * add comment to a post.
     */
    public function addComment(array $data,Post $post,int $userId)
    {
        $comment = $post->comments()->create([
            'user_id' => $userId,
            'content' => $data['content'],
        ]);

       return $comment;
    }

}
