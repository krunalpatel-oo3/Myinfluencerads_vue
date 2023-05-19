<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\CMSItem;

class CMSItemRequest extends FormRequest
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
        return CMSItem::getCMSItemValidationRulesArray( $request->get('id'), !empty($id) ? [] : ['status']  );
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'key.required' => 'Please enter key',
            'status.required' => 'Please select status',
            'text.required' => 'Please enter text',
        ];
    }
}
