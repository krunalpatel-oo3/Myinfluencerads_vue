<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Brand;
use App\Models\Gig;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class BrandRequest extends FormRequest
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
        return Brand::getBrandValidationRulesArray((int)$request->get('brand_id'),[]);

    }

    public function messages()
    {
        return [
            'name.required'        => 'Please enter name',
            'slug.unique'          => 'Please enter unique slug',
            // 'status.required'      => 'Please select Status',
            'category_id.required' => 'Please select category',
            'desc.required'        => 'Please enter description',
            'web_url.required|url' => 'Please provide a web url',
            'fb_url.required|url'  => 'Please provide a facebook url',
            'image.required'       => 'Please select file',
        ];
    }
}
