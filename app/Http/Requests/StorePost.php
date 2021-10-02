<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'bail|min:4|required|max:100',
            'content' => 'required',
            //'picture' => 'image' /** must be an image */
            //'picture' => 'image|mimes:jpeg,jpg' /** must be just jpeg or jpg */
            //'picture' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1024' /** max size 1MB = 1024 KB (kilobytes) */
            'picture' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1024|dimensions:min_height=500' /** min height 500px*/
            //'picture' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1024|dimensions:min_height=500,min_width=500' /** min width 500px*/
            //'picture' => 'image|mimes:jpeg,jpg,png,gif,svg|max:1024|dimensions:height=500,width=500' /**  height 500px , width 500px*/
        ];
    }
}
