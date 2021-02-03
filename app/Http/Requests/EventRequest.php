<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        /*
        return [
            'title' => 'required|min:10',
            'body' => 'required',
        ];*/
        
        
        return [];
    }
    
    public function messages()
    {
        
        return [];
        /*
        return [
            'title.required'  => 'Post Title is required.',
            'body.required'  => 'Post Body is required.',
        ];
         * 
         */
    }
}
