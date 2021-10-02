<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentUserResource extends JsonResource
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
            'nom' => $this->name,
            // 'email' => true ? $this->email : '' /** if the condition is met , return user email , else return '' */
            // 'email' => false ? $this->email : '' /** if the condition is met , return user email , else return '' */
            // 'email' => $this->when(condition , value , default )  /** use when , if the condition is met return user email , else return the default value , if it was added , else email does not return at all*/
            // 'email' => $this->when(true , $this->email)  
            // 'email' => $this->when(false , $this->email)  
            'email' => $this->when(false , $this->email , 'contact@example.com')  
        ];
    }
}
