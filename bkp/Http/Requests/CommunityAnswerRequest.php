<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\CommunityAnswer;

class CommunityAnswerRequest extends FormRequest
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

    public function rules()
    {
        $request= Request();
        return CommunityAnswer::getCommunityAnswerValidationRulesArray( $request->get('community_id'), $request->get('id'), ['community_id', 'user_id'] );
    }


    public function messages()
    {
        return [
            'answer_text.required' => 'Please enter comment',
        ];
    }
}
