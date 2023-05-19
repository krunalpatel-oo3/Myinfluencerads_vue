<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Company;
use Symfony\Component\HttpFoundation\Request;

class CompanyRequest extends FormRequest
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
        // dd(Request());
        $request = Request();
        $id = (int)$request->get('company_id');
        // dd(Company::getCompanyValidationRulesArray($id,[]));
        return Company::getCompanyValidationRulesArray($id,[]);
    }

    public function messages()
    {
        return [
            'name.required'        => 'Please enter name',
            'slug.unique'          => 'Please enter unique slug',
            'location.required'    => 'Please provide a location',
            'project_id.required'  => 'Please select project',
            'desc.required'        => 'Please enter description',
            'web_url.required|url' => 'Please provide a web url',
            'fb_url.required|url'  => 'Please provide a facebook url',
        ];
    }
}
