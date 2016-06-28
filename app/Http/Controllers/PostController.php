<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        if (!Post::validateRequest($request->all())) {
            return redirect()->back()->withErrors(Post::geterrors());
        }

        $post = new Post;
        $post->body = $request->body;

        if ($request->user()->posts()->save($post)) {
            return redirect()->route('dashboard')->with(['flash_message' => 'Post Successfully created!', 'flash_message_type' => 'success']);
        } else {
            return redirect()->route('dashboard')->with(['flash_message' => 'There are an error', 'flash_message_type' => 'warning']);
        }
    }

    public function deletePost(Post $post)
    {
        if ($post->delete()) {
            return redirect()->route('dashboard')->with(['flash_message' => 'Delete successfully!', 'flash_message_type' => 'success']);
        }
    }

    public function editPost(Request $request, Post $post)
    {
        $post->update($request->all());

        return response()->json(['body' => $post->body], 200);
    }

    public function likePost(Request $request, Post $post)
    {
        if (!$post) {
            return response()->json(['msg' => 'This post does not exists!'], 404);
        }

        $user = Auth::user();
        $postLike = strtolower($request->status) === 'like' ? true : false;
        $update = false;
        $getLike = $user->likes()->where('post_id', $post->id)->first();
        
        if ($getLike) {
            $alreadyLike = $getLike->like; 
            $update = true;

            if ($alreadyLike === $postLike) {
                $getLike->delete();

                return response()->json(['msg' => 'deleted!'], 200);
            }

        } else {
            $getLike = new Like;
        }

        $getLike->like = $postLike;
        $getLike->user_id = $user->id;
        $getLike->post_id = $post->id;

        if ($update) {
            $getLike->update();
            return response()->json(['msg' => 'updated!'], 200);
        } else {
            $getLike->save();
            return response()->json(['msg' => 'created!'], 200);
        }
    }
}
