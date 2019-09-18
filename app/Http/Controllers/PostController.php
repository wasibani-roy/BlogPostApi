<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Posts as PostsResource;
use App\Http\Resources\SinglePost;
use App\Http\Resources\SinglePostCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments'])->paginate(5);

        return new PostsResource($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();
        PostResource::withoutWrapping();
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->withCount(['user', 'comments'])->get();

        return new SinglePostCollection($post);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $currentUser = auth()->user()->id;

        if($post->user_id === $currentUser){
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->save();
            
            return new PostResource($post);
            
        }
        else{
            return response()->json(['Error' => 'You are not allowed to edit this post'], 401);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $currentUser = auth()->user()->id;

        if($post->user_id === $currentUser){
            $post->delete();
            return new PostResource($post);
            
        }
        else{
            return response()->json(['Error' => 'You are not allowed to delete this post'], 401);
        }
    }
}
