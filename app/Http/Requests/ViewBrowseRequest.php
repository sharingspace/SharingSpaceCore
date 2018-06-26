<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Helper;

class ViewBrowseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {       
        return  Helper::canAccess('view-browse-permission')
    
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
       
         ];
    }
}
