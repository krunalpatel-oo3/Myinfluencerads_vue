<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Education;

class EducationRequest extends FormRequest
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

        return Education::getEducationValidationRulesArray($request->get('id'), !empty($id) ? [] : ['status']);
    }

    public function messages()
    {
        return [
            'title.required'                 => 'Please enter title',
            'status.required'                => 'Please select status',
            'feature.required'               => 'Please select feature',
            'slug.unique'                    => 'Please enter unique slug',
            'education_category_id.required' => 'Please select education category',
            'platform_id.required'           => 'Please select platform',
            'desc.required'                  => 'Please enter description',
            'short_desc.required'            => 'Please enter short description',
            //'url.required'                   => 'Please enter url',
            'image.required'                 => 'Please select file',
            'book.required'                 => 'Please select book file',
            'document_type.required'         => 'Please enter document type',
        ];
    }
}
