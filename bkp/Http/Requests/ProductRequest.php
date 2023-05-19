<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Product;

class ProductRequest extends FormRequest
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
        $id = $request->get('id');
        // dd($id);
        return Product::getProductValidationRulesArray( $request->get('id'), [] );
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'name.unique' => 'Please enter unique name',
            'sku.required' => 'Please enter sku',
            'sku.unique' => 'Please enter unique sku',
            'slug.unique' => 'Please enter unique slug',

            'price.required' => 'Please enter price',
            'price.numeric' => 'Invalid price, please try again',
            'short_desc.required' => 'Please enter short description',
            'desc.required' => 'Please enter description',
        ];
    }
}
