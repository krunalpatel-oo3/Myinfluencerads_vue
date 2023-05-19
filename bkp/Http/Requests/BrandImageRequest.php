<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\BrandImage;

class BrandImageRequest extends FormRequest
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
        return BrandImage::getBrandImageValidationRulesArray( $request->get('brand_id'), $request->get('id'), $request->get('filename'), ['is_main']  );
    }

    public function messages()
    {
        return [
            'filename.required' => 'Please select file',
            'is_main.required' => 'Please select is main',
        ];

    }
}

