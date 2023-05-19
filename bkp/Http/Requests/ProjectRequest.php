<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Project;

class ProjectRequest extends FormRequest
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

        return Project::getProjectValidationRulesArray($request->get('id'), ['user_id']);
    }

    public function messages()
    {
        return [
            'name.required'         => 'Please enter name',
            'slug.unique'           => 'Please enter unique slug',
            'status.required'       => 'Please select Status',
            'category_id.required'  => 'Please select category',
            'platform_id.required'  => 'Please select platform',
            'desc.required'         => 'Please enter description',
            'desc.estimated_budget' => 'Please enter estimated budget',
        ];
    }
}
