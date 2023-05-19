<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\BrandProduct;

class BrandProductRequest extends FormRequest
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
        return BrandProduct::getBrandProductValidationRulesArray( $request->get('parent_brand_id'), $request->get('id'), ['brand_id']  );
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
