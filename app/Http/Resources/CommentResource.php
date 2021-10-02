<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'id' => $this->id,
            'contenu' => $this->content,
            'commentaire_date' => $this->created_at,
            // 'commentateur' => new CommentUserResource($this->user), 
            
            /** whenLoaded test if the user sent , so return the comment info , else it will not return but we will not have any error */ 
            'commentateur' => new CommentUserResource($this->whenLoaded('user')), 

            // 'commentateur' => CommentUserResource::collection($this->users), /** if it was a collection */
            // 'commentateur' => [
            //             'id' => $this->user->id,
            //             'nom' => $this->user->name
            //         ],
            
        ];
    }
}
