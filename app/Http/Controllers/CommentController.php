<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\PostComments;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with(['commenter'])->paginate(5);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $comment = new Comment;

        $comment->body = $request->input('body');
        $comment->post_id = $id;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::where('post_id', $id)->withCount(['author'])->get();
        // return response()->json($comments, 200);
        return new PostComments($comments);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $post = Post::findOrFail($id);
    //     $currentUser = auth()->user()->id;

    //     if($post->user_id === $currentUser){
    //         $post->title = $request->input('title');
    //         $post->body = $request->input('body');
    //         $post->save();
            
    //         return new PostResource($post);
            
    //     }
    //     else{
    //         return response()->json(['Error' => 'You are not allowed to edit this post'], 401);
    //     }

        
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $post = Post::findOrFail($id);
    //     $currentUser = auth()->user()->id;

    //     if($post->user_id === $currentUser){
    //         $post->delete();
    //         return new PostResource($post);
            
    //     }
    //     else{
    //         return response()->json(['Error' => 'You are not allowed to delete this post'], 401);
    //     }
    // }
}
