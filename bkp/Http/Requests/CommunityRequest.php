<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Community;

class CommunityRequest extends FormRequest
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

        return Community::getCommunityValidationRulesArray($request->get('id'), !empty($id) ? [] : ['status', 'title', 'status', 'user_id', 'desc' ]);
    }

    public function messages()
    {
        return [
            'title.required'   => 'Please enter title',
            'status.required'  => 'Please select status',
            'slug.unique'      => 'Please enter unique slug',
            'user_id.required' => 'Please select user',
            'desc.required'    => 'Please enter description',
        ];
    }
}
