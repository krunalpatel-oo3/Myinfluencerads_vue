<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\ProjectProduct;

class ProjectProductRequest extends FormRequest
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
        $request= Request();
        return ProjectProduct::getProjectProductValidationRulesArray( $request->get('parent_project_id'), $request->get('id'), ['project_id']  );
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'status.required' => 'Please select Status',
            'status.numeric' => 'Invalid status, please try again',
            'price.required' => 'Please enter price',
            'price.numeric' => 'Invalid price, please try again',
            'desc.required' => 'Please enter description',
        ];
    }
}
