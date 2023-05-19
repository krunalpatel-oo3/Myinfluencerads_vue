<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\ProjectCompany;

class ProjectCompanyRequest extends FormRequest
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
        return ProjectCompany::getProjectCompanyValidationRulesArray( $request->get('parent_company_id'), $request->get('id'), ['company_id']  );
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'desc.required' => 'Please enter description',
        ];
    }
}
