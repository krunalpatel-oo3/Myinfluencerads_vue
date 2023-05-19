<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Category;

class CategoryRequest extends FormRequest
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
        $request = Request();

        return Category::getCategoryValidationRulesArray($request->get('id'), ! empty($id) ? [] : ['status']);
    }

    public function messages()
    {
        return [
            'title.required'      => 'Please enter title',
            'slug.unique'         => 'Please enter unique slug',
            'status.required'     => 'Please select status',
            'short_desc.required' => 'Please enter short description',
        ];
    }

}
