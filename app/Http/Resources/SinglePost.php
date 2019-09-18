<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SinglePost extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => (string)$this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user' => [
                'author_name' => $this->user->name,
                'author_email' => $this->user->email
            ],
            'comments' => $this->comments,
            'number_of_comments' => $this->comments_count
        ];
    }

    // public function with($request){
    //     return [
    //         'version' => '1.0.0'
    //     ];
    // }
}
