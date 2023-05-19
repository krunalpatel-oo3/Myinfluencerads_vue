<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Tag;

class TagRequest extends FormRequest
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

        return Tag::getTagValidationRulesArray($request->get('category_id'), $request->get('id'),
            $request->get('title'), []);
    }

    public function messages()
    {
        return [
            'title.required'       => 'Please enter title',
            'slug.unique'          => 'Please enter unique slug',
            'category_id.required' => 'Please select category',
        ];
    }
}
