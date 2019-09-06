<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Posts extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => Post::collection($this->collection),
        ];
    }

    public function with($request){
        $comments = $this->collection->flatMap(
            function($post){
                return $post->comments;
            }
        );
        $authors = $this->collection->flatMap(
            function($post){
                return $post->user;
            }
        );
        $included = $authors->merge($comments)->unique();
        return [
            'included' => $included,
        ];
    }
}
